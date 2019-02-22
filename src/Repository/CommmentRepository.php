<?php

namespace App\Repository;

use App\Entity\Commment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Commment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commment[]    findAll()
 * @method Commment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommmentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Commment::class);
    }

    // /**
    //  * @return Commment[] Returns an array of Commment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Commment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
