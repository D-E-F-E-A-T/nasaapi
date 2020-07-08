<?php

declare(strict_types=1);

namespace App\NasaMarsAPI;

use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


final class ListParametersValidator
{
    private ValidatorInterface $validator;
    private Rovers $rovers;
    private Cameras $cameras;
    private array $errors = [];

    public function __construct(ValidatorInterface $validator, Rovers $rovers, Cameras $cameras)
    {
        $this->validator = $validator;
        $this->rovers = $rovers;
        $this->cameras = $cameras;
    }

    public function validate(array $optionalParameters)
    {
        $constraints = new Assert\Collection([
            'rover' => [new Assert\Choice([
                'choices' => $this->rovers->getRovers(),
                'message' => 'Expected one of those: ' . implode(', ', $this->rovers->getRovers()),
            ])],
            'camera' => [new Assert\Choice([
                'choices' => $this->cameras->getCameras(),
                'message' => 'Expected one of those: ' . implode(', ', $this->cameras->getCameras()),
            ])],
            'date_end' => [new Assert\Date(['message' => 'Provided date is invalid. Expected YYYY-MM-DD date format.']),
                new Assert\Callback(function ($object, ExecutionContextInterface $context) {
                    if (null === $dateEnd = $object) {
                        return;
                    }

                    $dateStart = $context->getRoot()['date_start'] ?? null;
                    if (!$dateStart) {
                        $context
                            ->buildViolation('The end date must be be provided with the start date')
                            ->addViolation();
                        return;
                    }

                    $dateEndParsed = date_parse_from_format('Y-m-d', $dateEnd);
                    $dateStartParsed = date_parse_from_format('Y-m-d', $dateStart);
                    if ($dateStartParsed['error_count'] !== 0 || $dateEndParsed['error_count'] !== 0) {
                        $context
                            ->buildViolation('Provided start or end date is invalid. Expected YYYY-MM-DD date format.')
                            ->addViolation();
                        return;
                    }

                    if ((new \DateTime($dateStart))->format('U') - (new \DateTime($dateEnd))->format('U') > 0) {
                        $context
                            ->buildViolation('The end date must be greater than the start date')
                            ->addViolation();
                    }
                }),
            ],
            'date_start' => [new Assert\Date(['message' => 'Provided date is invalid. Expected YYYY-MM-DD date format.'])],
        ]);

        $violations = $this->validator->validate($optionalParameters, $constraints);

        if (0 !== count($violations)) {

            /** @var ConstraintViolation $violation */
            foreach ($violations as $violation) {
                $this->errors[$violation->getPropertyPath()] = $violation->getMessage();
            }
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}