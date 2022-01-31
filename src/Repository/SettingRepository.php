<?php

namespace App\Repository;

use App\Entity\Setting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class SettingRepository
 * @package App\Repository
 */
class SettingRepository extends ServiceEntityRepository
{
    /**
     * SettingRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Setting::class);
    }

    /**
     * @param $section
     * @return array
     */
    public function findBySection($section)
    {
        return $this->createQueryBuilder('o')
            ->where('o.parentId = :parentId')
            ->setParameter('parentId', $section)
            ->getQuery()
            ->useQueryCache(true)
            ->enableResultCache(3600)
            ->getArrayResult();
    }
}
