<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
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

    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Product[] Returns an array of Product objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

/* public function findWithSearch($search) : array */
/* { */
/*     if($search->getProduct) */
/*     return $this->createQueryBuilder('p') */
/*     ->andWhere('p.bestSeller = :bestSeller') */
/*      ->setParameter('bestSeller', $bestSeller) */
/*      ->getQuery() */
/*     ->getResult(); */
/* } */
/*  */
/*  */
/*  */

public function findOneByBestSeller($bestSeller) : array
{
    return $this->createQueryBuilder('p')
    ->andWhere('p.bestSeller = :bestSeller')
     ->setParameter('bestSeller', $bestSeller)
     ->getQuery()
    ->getResult();
}


public function findOneByNouveaute($nouveaute) : array
{
    return $this->createQueryBuilder('p')
    ->andWhere('p.nouveaute = :nouveaute')
     ->setParameter('nouveaute', $nouveaute)
     ->getQuery()
    ->getResult();
}




public function findWithSearch($critere) : array
{
    return $this->createQueryBuilder('product')
    ->andWhere('product.title  LIKE :string')
    ->orWhere('product.excerpt LIKE :string')
     ->setParameter('string', '%'.$critere.'%')
     ->orderBy('product.id', 'ASC')
     ->setMaxResults(10)
     ->getQuery()
    ->getResult();
}

}