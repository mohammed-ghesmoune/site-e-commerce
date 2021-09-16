<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function cartAmount($cart)
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.size', 's')
            ->andWhere('o.cart = :cart')
            ->setParameter('cart', $cart)
            ->select('SUM(s.price * o.quantity) as amount')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findOrderProducts($cart)
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.cart', 'ca')
            ->addSelect('ca')
            ->innerJoin('o.size', 's')
            ->addSelect('s')
            ->leftJoin('s.sales','sa')
            ->addSelect('sa')
            ->innerJoin('s.product', 'p')
            ->addSelect('p')
            ->innerJoin('s.color', 'co')
            ->addSelect('co')
            ->innerJoin('co.images', 'im')
            ->addSelect('im')
            ->andWhere('o.cart = :cart')
            ->setParameter('cart', $cart)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Order[] Returns an array of Order objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Order
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
