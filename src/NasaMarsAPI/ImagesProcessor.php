<?php

declare(strict_types=1);

namespace App\NasaMarsAPI;

use App\Entity\MarsPhotos;

final class ImagesProcessor
{
    public function createMarsPhotoCollection(array $photos): MarsPhotosCollection
    {
        $marsPhotoCollection = new MarsPhotosCollection();
        foreach ($photos as $photo) {
            $marsPhoto = new MarsPhotos();
            $marsPhoto
                ->setEarthDate(new \DateTime($photo['earth_date'] ?? null))
                ->setCamera($photo['camera']['name'] ?? null)
                ->setRover($photo['rover']['name'] ?? null)
                ->setUrl($photo['img_src'] ?? null)
                ->setSol($photo['sol'] ?? null);
            $marsPhotoCollection->add($marsPhoto);
        }

        return $marsPhotoCollection;
    }
}