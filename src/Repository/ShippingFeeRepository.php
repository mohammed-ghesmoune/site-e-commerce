<?php

namespace App\Repository;

use App\Entity\ShippingFee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShippingFee|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShippingFee|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShippingFee[]    findAll()
 * @method ShippingFee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShippingFeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShippingFee::class);
    }

    // /**
    //  * @return ShippingFee[] Returns an array of ShippingFee objects
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
    public function findOneBySomeField($value): ?ShippingFee
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
