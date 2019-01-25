<?php

namespace App\Repository;

use App\Entity\SubService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SubService|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubService|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubService[]    findAll()
 * @method SubService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubServiceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SubService::class);
    }

    // /**
    //  * @return SubService[] Returns an array of SubService objects
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
    public function findOneBySomeField($value): ?SubService
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
