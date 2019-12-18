<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {

        parent::__construct($registry, Article::class);
    }

    public function getAllByAuthor(Author $author)
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a')
            ->join('a.author', 'auth')
            ->where('auth.id = :id')
            ->setParameter('id', $author->getId())
        ;
        return $qb->getQuery();
    }

    public function  getAllArticles(){
        $qb = $this->createQueryBuilder('a')
            ->select('a');
        return $qb->getQuery();
    }

    // /**
    //  * @return Article[] Returns an array of Artcile objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Artcile
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
