<?php
declare(strict_types=1);

namespace Practice\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Practice\Entity\Vehicle;

class VehicleRepository extends EntityRepository
{
    public function getPage(int $pageSize = 10, int $pageNumber = 1): array
    {
        $from = ($pageNumber - 1) * $pageSize;

        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('v')
            ->from(Vehicle::class, 'v')
            ->orderBy('v.VehicleID', 'ASC')
            ->setFirstResult($from)
            ->setMaxResults($pageSize);

        return $queryBuilder->getQuery()->getResult();
    }

    public function getPageV2(int $pageSize = 10, int $pageNumber = 1): Paginator
    {
        $from = ($pageNumber - 1) * $pageSize;

        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('v')
            ->from(Vehicle::class, 'v')
            ->orderBy('v.VehicleID', 'ASC')
            ->setFirstResult($from)
            ->setMaxResults($pageSize);

        return new Paginator($queryBuilder->getQuery());
    }
}