<?php

namespace App\Repository;

use App\Entity\Kindergarten;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Kindergarten|null find($id, $lockMode = null, $lockVersion = null)
 * @method Kindergarten|null findOneBy(array $criteria, array $orderBy = null)
 * @method Kindergarten[]    findAll()
 * @method Kindergarten[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KindergartenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kindergarten::class);
    }

    // /**
    //  * @return Kindergarten[] Returns an array of School objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Kindergarten
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getAllKindergarten()
    {
        $result = $this->createQueryBuilder('k')
            ->select('k.id, k.name')
            ->getQuery()
            ->getResult();

        $response = [];
        foreach ($result as $array) {
            $response[$array['id']] = $array['name'];
        }

        return $response;
    }
}
