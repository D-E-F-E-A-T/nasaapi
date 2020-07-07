<?php

declare(strict_types=1);

namespace App\NasaMarsAPI;

final class Rovers
{
    const CURIOSITY = 'curiosity';
    const OPPORTUNITY = 'opportunity';
    const SPIRIT = 'spirit';

    public function getRovers(): array
    {
        return [
            self::CURIOSITY,
            self::OPPORTUNITY,
            self::SPIRIT,
        ];
    }

}