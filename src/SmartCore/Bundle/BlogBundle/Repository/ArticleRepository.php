<?php

namespace SmartCore\Bundle\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;
use SmartCore\Bundle\BlogBundle\Model\ArticleInterface;
use SmartCore\Bundle\BlogBundle\Model\CategoryInterface;
use SmartCore\Bundle\BlogBundle\Model\TagInterface;

class ArticleRepository extends EntityRepository implements ArticleRepositoryInterface
{
    /**
     * @param integer $limit
     * @return ArticleInterface[]|null
     */
    public function findLast($limit = 10)
    {
        return $this->findBy([
            'enabled' => true,
        ], [
            'created_at' => 'DESC',
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
     * @param CategoryInterface[]|array $categories
     * @param int|null $limit
     * @param int|null $offset
     * @return ArticleInterface[]|null
     */
    public function findByCategories(array $categories = [], $limit = null, $offset = null)
    {
        $qb = $this
            ->createQueryBuilder('a')
            ->orderBy('a.created_at', 'DESC');

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
            ORDER BY a.created_at DESC
        ");
    }

    /**
     * @param \DateTime|null $firstDate
     * @param \DateTime|null $lastDate
     * @return \Doctrine\ORM\Query
     */
    public function getFindByDateQuery(\DateTime $firstDate = null, \DateTime $lastDate = null)
    {
        return $this->_em->createQuery("
            SELECT a
            FROM {$this->_entityName} AS a
            WHERE a.enabled = true
            AND a.created_at > :firstDate
            AND a.created_at < :lastDate
            ORDER BY a.created_at DESC
        ")->setParameters([
            'firstDate' => $firstDate,
            'lastDate'  => $lastDate,
        ]);
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
            ORDER BY a.created_at DESC
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

    /**
     * @param int $limit
     * @return array
     */
    public function getArchiveMonthly($limit = 24)
    {
        if ('mysql' != $this->_em->getConnection()->getDatabasePlatform()->getName()) {
            throw new \Exception('

                Посчет архива статей, пока работает только с БД MySQL.
                Call in SmartCore\Bundle\BlogBundle\Repository\ArticleRepository::getArchiveMonthly();

            ');
        }

        return $this->_em->getConnection()->fetchAll('
            SELECT date_format(created_at, "%Y-%m-01 00:00:00" ) AS date,
                COUNT(1) AS count
            FROM ' . $this->getClassMetadata()->getTableName() . '
            GROUP BY date_format(created_at, "%Y-%m" ) DESC
            ORDER BY date DESC
            LIMIT 0, ' . $limit
        );
    }
}
