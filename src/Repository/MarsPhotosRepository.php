<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\MarsPhotos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
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

    public function getList(?array $optionalParameters = null)
    {
        $queryBuilder = $this->createQueryBuilder('m');

        if ($dateStart = $optionalParameters['date_start'] ?? null) {
            if (!$dateEnd = $optionalParameters['date_end'] ?? null) {
                $dateEnd = $dateStart;
            }
            $queryBuilder->where('m.earthDate BETWEEN :date_start AND :date_end')
                ->setParameters([
                    'date_start' => $dateStart,
                    'date_end' => $dateEnd,
                ]);
        }

        if ($rover = $optionalParameters['rover'] ?? null) {
            $queryBuilder->andWhere('m.rover = :rover')
                ->setParameter('rover', $rover);
        }
        if ($camera = $optionalParameters['camera'] ?? null) {
            $queryBuilder->andWhere('m.camera = :camera')
                ->setParameter('camera', $camera);
        }

        return $queryBuilder
            ->select('partial m.{id, nasaid, earthDate, rover, camera}')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
    }
}
