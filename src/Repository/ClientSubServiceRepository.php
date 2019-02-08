<?php

namespace App\Repository;

use App\Entity\ClientSubService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ClientSubService|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientSubService|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientSubService[]    findAll()
 * @method ClientSubService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientSubServiceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ClientSubService::class);
    }

    // /**
    //  * @return ClientSubService[] Returns an array of ClientSubService objects
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
    public function findOneBySomeField($value): ?ClientSubService
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
