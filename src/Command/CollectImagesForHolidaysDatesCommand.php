<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\HolidaysDates;
use App\Entity\MarsPhotos;
use App\NasaMarsAPI\ImagesProcessor;
use App\NasaMarsAPI\NasaMarsAPIClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CollectImagesForHolidaysDatesCommand extends Command
{
    protected static $defaultName = 'nasa-mars-api:refresh-images';
    private NasaMarsAPIClient $nasaMarsAPIClient;
    private EntityManagerInterface $entityManager;
    private ImagesProcessor $imagesProcessor;

    public function __construct(
        NasaMarsAPIClient $nasaMarsAPIClient,
        EntityManagerInterface $entityManager,
        ImagesProcessor $imagesProcessor
    )
    {
        $this->nasaMarsAPIClient = $nasaMarsAPIClient;
        $this->entityManager = $entityManager;
        $this->imagesProcessor = $imagesProcessor;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //TODO: Inject Repositories, add transaction, remove logic to service
        $this->entityManager->getRepository(MarsPhotos::class)->clearTable();
        $holidaysDates = $this->entityManager->getRepository(HolidaysDates::class)->findAll();
        if ([] === $holidaysDates) {
            $output->writeln("<error>There are no holidays dates in DB. Run " . RefreshHolidaysDateCommand::getDefaultName() . "</error>");

            return 1;
        }

        try {
            /** @var HolidaysDates $date */
            foreach ($holidaysDates as $date) {
                $imagesToProcess = $this->nasaMarsAPIClient->getImagesForDate($date);
                if ($imagesToProcess) {
                    $marsPhotosCollection = $this->imagesProcessor->createMarsPhotoCollection($imagesToProcess);
                    if ($marsPhotosCollection->valid()) {
                        foreach ($marsPhotosCollection as $marsPhoto) {
                            $this->entityManager->persist($marsPhoto);
                        }
                    }
                }
            }
        } catch (\Exception $exception) {
            $output->writeln("<error>{$exception->getMessage()}</error>");

            return 1;
        }


        $this->entityManager->flush();
        $output->writeln('<info>Images updated correctly.</info>');

        return 0;
    }

}