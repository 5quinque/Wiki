<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    //public function page($page_no): object
    //{
    //    return $this
    //        ->setMaxResults(8)
    //        ->setFirstResult(($page_no - 1) * 8);
    //}

    public function findByLike($query): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.title LIKE :query')
            ->setParameter('query', "%$query%")
            ->orderBy('p.created', 'ASC')
            ->getQuery()->getResult();
    }
    public function findByLikePage($query, $page): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.title LIKE :query')
            ->setParameter('query', "%$query%")
            ->setMaxResults(8)
            ->setFirstResult(($page - 1) * 8)
            ->orderBy('p.created', 'ASC')
            ->getQuery()->getResult();
    }

    public function findByPage($page): array
    {
        return $this->createQueryBuilder('p')
            ->setMaxResults(8)
            ->setFirstResult(($page - 1) * 8)
            ->orderBy('p.created', 'ASC')
            ->getQuery()->getResult();
    }

    public function findByCategoryPage($category_id, $page): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.category = :category_id')
            ->setParameter('category_id', $category_id)
            ->setMaxResults(8)
            ->setFirstResult(($page - 1) * 8)
            ->orderBy('p.created', 'ASC')
            ->getQuery()->getResult();
    }

    public function getLikePageCount($query)
    {
        $count = intval($this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->andWhere('p.title LIKE :query')
            ->setParameter('query', "%$query%")
            ->getQuery()->getSingleScalarResult());
        $pageCount = $count / 8;

        return ceil($pageCount);
    }

    public function getCategoryPageCount($category_id)
    {
        $count = intval($this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->andWhere('p.category = :category_id')
            ->setParameter('category_id', $category_id)
            ->getQuery()->getSingleScalarResult());
        $pageCount = $count / 8;

        return ceil($pageCount);
    }

    public function getPageCount()
    {
        $count = intval($this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->getQuery()->getSingleScalarResult());
        $pageCount = $count / 8;

        return ceil($pageCount);
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
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
    public function findOneBySomeField($value): ?Post
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
