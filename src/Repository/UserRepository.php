<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class UserRepository
 * @package App\Repository
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * UserRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Zwraca 12 ostatnio zarejestrowanych osób
     * @return mixed
     */
    public function getLatestRegistered()
    {
        $builder = $this->createQueryBuilder('o')
            ->setMaxResults(12)
            ->orderBy('o.createdAt', 'DESC')
            ->getQuery()
            ->useQueryCache(true)
            ->enableResultCache(3600)
            ->getResult();

        return $builder;
    }

    /**
     * Zwraca użytkowników o podanej roli
     * @param $role
     * @return int|mixed|string
     */
    public function getByRole($role)
    {
        $builder = $this->createQueryBuilder('o')
            ->where('o.roles LIKE :roles')
            ->setParameter('roles', '%' . $role . '%')
        ;

        return $builder->getQuery()->getResult();
    }
}
