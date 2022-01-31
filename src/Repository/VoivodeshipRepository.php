<?php

namespace App\Repository;

use App\Entity\Voivodeship;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Voivodeship|null find($id, $lockMode = null, $lockVersion = null)
 * @method Voivodeship|null findOneBy(array $criteria, array $orderBy = null)
 * @method Voivodeship[]    findAll()
 * @method Voivodeship[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoivodeshipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Voivodeship::class);
    }

    // /**
    //  * @return Voivodeship[] Returns an array of Voivodeship objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Voivodeship
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
