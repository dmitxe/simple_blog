<?php

namespace SmartCore\Bundle\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;
use SmartCore\Bundle\BlogBundle\Model\ArticleInterface;
use SmartCore\Bundle\BlogBundle\Model\CategoryInterface;
use SmartCore\Bundle\BlogBundle\Model\TagInterface;

class ArticleRepository extends EntityRepository implements ArticleRepositoryInterface
{
    /**
     * @param integer|null $limit
     * @return ArticleInterface[]|null
     */
    public function findLast($limit = null)
    {
        return $this->findBy([
            'enabled'    => true,
        ], [
            'id'         => 'DESC',
        ], $limit);
    }

    /**
     * @param TagInterface $tag
     * @return ArticleInterface[]|null
     */
    public function findByTag(TagInterface $tag)
    {
        return $this->getFindByTagQuery($tag)->getResult();
    }

    /**
     * @param CategoryInterface|null $category
     * @param integer|null $offset
     * @param integer|null $limit
     * @return ArticleInterface[]|null
     */
    public function findByCategory(CategoryInterface $category = null, $limit = null, $offset = null)
    {
        $query = $this->getFindByCategoryQuery($category);
        $query
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return $query->getResult();
    }

    /**
     * @param CategoryInterface[]|array $categories
     * @param int|null $limit
     * @param int|null $offset
     * @return ArticleInterface[]|null
     */
    public function findByCategories(array $categories = [], $limit = null, $offset = null)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('a')
           ->from($this->_entityName, 'a')
           ->orderBy('a.id', 'DESC');

        foreach ($categories as $key => $category) {
            $id = $category->getId();

            if (0 == $key) {
                $qb->where('a.category = :id' . $id);
            } else {
                $qb->orWhere('a.category = :id' . $id);
            }

            $qb->setParameter('id' . $id, $category);
        }

        $query = $qb->getQuery();

        $query
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return $query->getResult();
    }

    /**
     * @param CategoryInterface|null $category
     * @return \Doctrine\ORM\Query
     *
     * @todo $category
     * @todo enabled
     */
    public function getFindByCategoryQuery(CategoryInterface $category = null)
    {
        return $this->_em->createQuery("
            SELECT a
            FROM {$this->_entityName} AS a
            WHERE a.enabled = true
            ORDER BY a.id DESC
        ");
    }

    /**
     * @param TagInterface $tag
     * @return \Doctrine\ORM\Query
     *
     * @todo enabled
     */
    public function getFindByTagQuery(TagInterface $tag)
    {
        return $this->_em->createQuery("
            SELECT a
            FROM {$this->_entityName} AS a
            JOIN a.tags AS t
            WHERE t = :tag
            AND a.enabled = true
            ORDER BY a.id DESC
        ")->setParameter('tag', $tag);
    }

    /**
     * @param CategoryInterface|null $category
     * @return integer
     *
     * @todo поддержку категорий.
     */
    public function getCountByCategory(CategoryInterface $category = null)
    {
        $query = $this->_em->createQuery("
            SELECT COUNT(a.id)
            FROM {$this->_entityName} a
            WHERE a.enabled = true
        ");

        return $query->getSingleScalarResult();
    }
}
