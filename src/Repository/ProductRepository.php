<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */

    public function addJoinEntities($qb)
    {
        return $qb->innerJoin('p.category', 'c')
            ->addSelect('c')
            ->innerJoin('p.subCategory', 'sc')
            ->addSelect('sc')
            ->innerJoin('p.colors', 'co')
            ->addSelect('co')
            ->innerJoin('co.images', 'im')
            ->addSelect('im')
            ->innerJoin('co.sizes', 'si')
            ->addSelect('si')
            ->leftJoin('si.sales', 'sa')
            ->addSelect('sa')
            ->andWhere('si.deleted = 0');
    }

    /**
     * @return Query
     */

    public function findProducts($category = null, $subCategory = null, $filterData, $searchParam): Query
    {

        $qb = $this->createQueryBuilder('p');

        $this->addJoinEntities($qb);

        if ($searchParam) {
            $qb->andWhere('p.name LIKE :productName')
                ->setParameter('productName', '%' . trim($searchParam) . '%');
        }

        if ($filterData) {

            if (!$filterData['Category']->isEmpty()) {
                foreach ($filterData['Category'] as $category) {
                    $categryName[] = $category->getName();
                }
                $qb->andWhere('c.name IN (:category)')
                    ->setParameter('category', $categryName);
            } else {
                if ($category) {
                    $qb->andWhere('c.name = :category')
                        ->setParameter('category', $category);
                }
            }
            if (!$filterData['SubCategory']->isEmpty()) {
                foreach ($filterData['SubCategory'] as $subCategory) {
                    $subCategryName[] = $subCategory->getName();
                }
                $qb->andWhere('sc.name IN (:subCategory)')
                    ->setParameter('subCategory', $subCategryName);
            } else {
                if ($subCategory) {
                    $qb->andWhere('sc.name = :subCategory')
                        ->setParameter('subCategory', $subCategory);
                }
            }
            if (!$filterData['Color']->isEmpty()) {
                foreach ($filterData['Color'] as $color) {
                    $colorName[] = $color->getName();
                }
                $qb->andWhere('co.name IN (:color)')
                    ->setParameter('color', $colorName);
            }

            if ($filterData['SizeMin']) {
                $qb->andWhere('si.name > :sizeMin')
                    ->setParameter('sizeMin', $filterData['SizeMin']->getName());
            }
            if ($filterData['SizeMax']) {
                $qb->andWhere('si.name < :sizeMax')
                    ->setParameter('sizeMax', $filterData['SizeMax']->getName());
            }
            if ($filterData['PriceMin']) {
                $qb->andWhere('si.price > :priceMin')
                    ->setParameter('priceMin', $filterData['PriceMin']);
            }
            if ($filterData['PriceMax']) {
                $qb->andWhere('si.price < :priceMax')
                    ->setParameter('priceMax', $filterData['PriceMax']);
            }

            /*
        if ($sort && $dir) {
        $qb->orderBy($sort, $dir);
        }
         */
        } else {
            if ($category) {
                $qb->andWhere('c.name = :category')
                    ->setParameter('category', $category);
            }
            if ($subCategory) {
                $qb->andWhere('sc.name = :subCategory')
                    ->setParameter('subCategory', $subCategory);
            }
        }
        return $qb->getQuery();
    }

    /**
     *
     * @return Product
     */

    public function findProduct($id)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.colors', 'co')
            ->addSelect('co')
            ->leftJoin('co.images', 'im')
            ->addSelect('im')
            ->innerJoin('co.sizes', 'si')
            ->addSelect('si')
            ->leftJoin('si.sales', 'sa')
            ->addSelect('sa')
            ->andWhere('si.deleted = 0')
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
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
public function findOneBySomeField($value): ?Product
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
