<?php

namespace App\Repository;

use App\Entity\PasswordResetTokenEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PasswordResetTokenEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method PasswordResetTokenEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method PasswordResetTokenEntity[]    findAll()
 * @method PasswordResetTokenEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PasswordResetTokenEntityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PasswordResetTokenEntity::class);
    }

    // /**
    //  * @return PasswordResetTokenEntity[] Returns an array of PasswordResetTokenEntity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PasswordResetTokenEntity
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
