<?php

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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HolidaysDates::class);
    }

    // /**
    //  * @return HolidaysDates[] Returns an array of HolidaysDates objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HolidaysDates
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
