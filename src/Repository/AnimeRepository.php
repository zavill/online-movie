<?php

namespace App\Repository;

use App\Entity\Anime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Anime|null find($id, $lockMode = null, $lockVersion = null)
 * @method Anime|null findOneBy(array $criteria, array $orderBy = null)
 * @method Anime[]    findAll()
 */
class AnimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Anime::class);
    }

    /**
     * @param $criteria
     * @param null $orderBy
     * @param null $limit
     * @param null $offset
     * @return Anime[]
     */
    public function findBy($criteria, $orderBy = null, $limit = null, $offset = null): array
    {
        $query = $this->createQueryBuilder('a');

        foreach ($criteria as $propName => $propValue) {
            if ($propName === 'category') {
                $query->andWhere(':category MEMBER of a.category');
                $query->setParameter('category', $propValue);
            } else {
                $query->andWhere("a.$propName = :$propName");
                $query->setParameter("$propName", $propValue);
            }
        }

        if ($orderBy !== null) {
            foreach ($orderBy as $sortName => $sortType) {
                $query->addOrderBy("a.$sortName", $sortType);
            }
        }

        if ($limit !== null) {
            $query->setMaxResults($limit);
        }

        if ($offset !== null) {
            $query->setFirstResult($offset);
        }

        return $query->getQuery()->getResult();
    }

    /**
     * @param int $limit
     * @return array
     */
    public function getNewAnime($limit = 4): array
    {
        return parent::findBy([], ['createdAt' => 'DESC'], $limit);
    }

    /**
     * @param int $limit
     * @return array
     */
    public function getRecommendations($limit = 3): array
    {
        return parent::findBy([], ['views' => 'DESC'], $limit);
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
