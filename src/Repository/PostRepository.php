<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;

/* [todo] where to put this? */
class PageQueryBuilder extends \Doctrine\ORM\QueryBuilder
{
    public function page($page_no): array
    {
        return $this
            ->setMaxResults(8)
            ->setFirstResult(($page_no - 1) * 8)
            ->getQuery()->getResult();
    }
}

/**
 * @method Post[]    findAll()
 * @method Post[]    findByLike(string $query)
 * @method Post[]    findByCategory(string $query)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function createQueryBuilder($alias, $indexBy = null)
    {
        return (new PageQueryBuilder($this->_em))
            ->select($alias)
            ->from($this->_entityName, $alias, $indexBy);
    }

    public function findByLike(string $query): object
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.title LIKE :query')
            ->setParameter('query', "%$query%")
            ->orderBy('p.created', 'ASC');
    }

    public function findAll(): object
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.created', 'ASC');
    }

    public function findByCategory(int $category_id): object
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.category = :category_id')
            ->setParameter('category_id', $category_id)
            ->orderBy('p.created', 'ASC');
    }

    public function getLikePageCount(string $query): int
    {
        $count = intval($this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->andWhere('p.title LIKE :query')
            ->setParameter('query', "%$query%")
            ->getQuery()->getSingleScalarResult());
        $pageCount = $count / 8;

        return (int) ceil($pageCount);
    }

    public function getCategoryPageCount(int $category_id): int
    {
        $count = intval($this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->andWhere('p.category = :category_id')
            ->setParameter('category_id', $category_id)
            ->getQuery()->getSingleScalarResult());
        $pageCount = $count / 8;

        return (int) ceil($pageCount);
    }

    public function getPageCount(): int
    {
        $count = intval($this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->getQuery()->getSingleScalarResult());
        $pageCount = $count / 8;

        return (int) ceil($pageCount);
    }

}
