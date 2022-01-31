<?php

namespace App\Repository;

use App\Entity\Redirect;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class RedirectRepository
 * @package App\Repository
 */
class RedirectRepository extends ServiceEntityRepository
{
    /**
     * RedirectRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Redirect::class);
    }
}
