<?php

namespace App\Repository;

use App\Entity\Anime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Anime|null find($id, $lockMode = null, $lockVersion = null)
 * @method Anime|null findOneBy(array $criteria, array $orderBy = null)
 * @method Anime[]    findAll()
 * @method Anime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Anime::class);
    }

    /**
     * @param $categoryId
     * @return Anime[]
     */
    public function findByCategory($categoryId): array
    {
        return $this->createQueryBuilder('a')
            ->join('App\Entity\Categories', 'c')
            ->andWhere('c.id = :category_id')
            ->setParameter('category_id', $categoryId)
            ->getQuery()
            ->getResult();
    }

    public function getNewAnime($limit = 4)
    {
        return parent::findBy([], ['createdAt' => 'DESC'], $limit);
    }
    // /**
    //  * @return Anime[] Returns an array of Anime objects
    //  */

//    public function findByExampleField($value)
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }


    /*
    public function findOneBySomeField($value): ?Anime
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
