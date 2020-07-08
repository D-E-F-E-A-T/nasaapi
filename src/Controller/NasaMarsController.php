<?php

namespace App\Controller;

use App\Entity\MarsPhotos;
use App\Repository\MarsPhotosRepository;
use App\NasaMarsAPI\ListParametersValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class NasaMarsController extends AbstractController
{
    /**
     * @Route("/nasa-mars/api/v1/list", name="nasa-mars-list")
     */
    public function list(
        Request $request,
        ListParametersValidator $validator,
        MarsPhotosRepository $marsPhotosRepository
    )
    {
        $optionalParameters = [
            'rover' => $request->query->get('rover'),
            'camera' => $request->query->get('camera'),
            'date_end' => $request->query->get('date_end'),
            'date_start' => $request->query->get('date_start'),
        ];

        if (!array_filter($optionalParameters)) {
            $allPhotos = $marsPhotosRepository->getList();
            return new JsonResponse($allPhotos, 200);
        }

        $validator->validate($optionalParameters);
        if ($errors = $validator->getErrors()) {
            return new JsonResponse($errors, 400);
        }

        $filteredPhotos = $marsPhotosRepository->getList($optionalParameters);
        return new JsonResponse($filteredPhotos, 200);
    }

    /**
     * @Route("/nasa-mars/api/v1/image/{marsPhoto}/details", name="nasa-mars-image-details")
     */
    public function imageDetails(MarsPhotos $marsPhoto = null)
    {
        if (!$marsPhoto) {
            return new JsonResponse('PhotoDetailsNotFound', 404);
        }

        return new JsonResponse($marsPhoto, 200);
    }
}
