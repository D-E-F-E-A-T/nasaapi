<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\MarsPhotos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MarsPhotos|null find($id, $lockMode = null, $lockVersion = null)
 * @method MarsPhotos|null findOneBy(array $criteria, array $orderBy = null)
 * @method MarsPhotos[]    findAll()
 * @method MarsPhotos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarsPhotosRepository extends ServiceEntityRepository
{
    use ClearTableTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MarsPhotos::class);
    }

}
