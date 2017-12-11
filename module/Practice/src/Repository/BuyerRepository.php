<?php
declare(strict_types=1);

namespace Practice\Repository;

use Doctrine\ORM\EntityRepository;
use Practice\Entity\Buyer;

class BuyerRepository extends EntityRepository
{
    /**
     * @param int $buyerID
     * @return array
     */
    public function findBuyerByID(int $buyerID)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('b')
            ->from(Buyer::class, 'b')
            ->where('b.BuyerID=:BuyerID')
            ->setParameter(':BuyerID', $buyerID);

        return $queryBuilder->getQuery()->getResult();
    }

    public function getAll(): array
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('b')
            ->from(Buyer::class, 'b');

        return $queryBuilder->getQuery()->getResult();
    }
}