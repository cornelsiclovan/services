<?php

namespace App\Repository;

use App\Entity\ServiceOffer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ServiceOffer|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceOffer|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceOffer[]    findAll()
 * @method ServiceOffer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceOfferRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ServiceOffer::class);
    }

    // /**
    //  * @return ServiceOffer[] Returns an array of ServiceOffer objects
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
    public function findOneBySomeField($value): ?ServiceOffer
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
