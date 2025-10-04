<?php

namespace App\Repository;

use App\Document\Product;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class ProductRepository extends DocumentRepository
{
    public function findAllOrderedByPosition(): array
    {
        return $this->createQueryBuilder()
            ->field('position')->exists(true)
            ->sort('position', 'ASC')
            ->getQuery()
            ->execute()
            ->toArray();
    }

    public function findTop10(): array
    {
        return $this->createQueryBuilder()
            ->field('position')->exists(true)
            ->sort('position', 'ASC')
            ->limit(10)
            ->getQuery()
            ->execute()
            ->toArray();
    }
}
