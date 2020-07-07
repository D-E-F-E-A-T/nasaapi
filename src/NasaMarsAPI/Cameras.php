<?php

declare(strict_types=1);

namespace App\NasaMarsAPI;

final class Cameras
{
    const FHAZ = 'fhaz';
    const RHAZ = 'rhaz';

    public function getCameras(): array
    {
        return [
            self::FHAZ,
            self::RHAZ,
        ];
    }

}