<?php

declare(strict_types=1);

namespace App\Repository;

trait ClearTableTrait
{
    public function clearTable()
    {
        $this->createQueryBuilder('x')
            ->delete()
            ->getQuery()
            ->execute();
    }
}