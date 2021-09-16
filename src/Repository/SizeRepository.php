<?php

namespace App\Repository;

use DateTime;
use App\Entity\Size;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Size|null find($id, $lockMode = null, $lockVersion = null)
 * @method Size|null findOneBy(array $criteria, array $orderBy = null)
 * @method Size[]    findAll()
 * @method Size[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SizeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Size::class);
    }

     /**
     * @return Size[] Returns an array of Size objects
     */
    
    public function findProductById($id)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.color', 'co')
            ->addSelect('co')
            ->innerJoin('co.images', 'im')
            ->addSelect('im')
            ->innerJoin('s.product', 'p')
            ->addSelect('p')
            ->andWhere('s.deleted = 0')
            ->andWhere('s.id = :id')
            ->setParameter('id', $id)           
            ->getQuery()
            ->getOneOrNullResult();
        ;
    }
    public function findSaleProduct()
    {
        return $this->createQueryBuilder('s')
        ->innerJoin('s.sales', 'sa')
        ->addSelect('sa')
        ->andWhere('sa.endDate > :now')
        ->andWhere('sa.startDate <= :now')
        ->setParameter('now', new \DateTime())
            ->innerJoin('s.color', 'co')
            ->addSelect('co')
            ->innerJoin('co.images', 'im')
            ->addSelect('im')
            ->innerJoin('s.product', 'p')
            ->addSelect('p')
            ->andWhere('s.deleted = 0')        
            ->getQuery()
            ->getResult();
        ;
    }

    // /**
    //  * @return Size[] Returns an array of Size objects
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
    public function findOneBySomeField($value): ?Size
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
