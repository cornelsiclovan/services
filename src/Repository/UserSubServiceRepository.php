<?php

namespace App\Repository;

use App\Entity\UserSubService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserSubService|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserSubService|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserSubService[]    findAll()
 * @method UserSubService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserSubServiceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserSubService::class);
    }

    // /**
    //  * @return UserSubService[] Returns an array of UserSubService objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserSubService
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
