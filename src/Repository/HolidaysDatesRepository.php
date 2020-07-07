<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\HolidaysDates;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HolidaysDates|null find($id, $lockMode = null, $lockVersion = null)
 * @method HolidaysDates|null findOneBy(array $criteria, array $orderBy = null)
 * @method HolidaysDates[]    findAll()
 * @method HolidaysDates[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HolidaysDatesRepository extends ServiceEntityRepository
{
    use ClearTableTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HolidaysDates::class);
    }

}
