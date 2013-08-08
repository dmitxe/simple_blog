<?php

namespace SmartCore\Bundle\BlogBundle\Repository;

use SmartCore\Bundle\BlogBundle\Model\ArticleInterface;
use SmartCore\Bundle\BlogBundle\Model\CategoryInterface;
use SmartCore\Bundle\BlogBundle\Model\TagInterface;

interface ArticleRepositoryInterface
{
    /**
     * @param int|null $limit
     * @return ArticleInterface[]|null
     */
    public function findLast($limit = null);

    /**
     * @param TagInterface $tag
     * @return ArticleInterface[]|null
     */
    public function findByTag(TagInterface $tag);

    /**
     * @param CategoryInterface|null $category
     * @param int|null $offset
     * @param int|null $limit
     * @return ArticleInterface[]|null
     */
    public function findByCategory(CategoryInterface $category = null, $limit = null, $offset = null);

    /**
     * @param CategoryInterface|null $category
     * @return \Doctrine\ORM\Query
     */
    public function getFindByCategoryQuery(CategoryInterface $category = null);

    /**
     * @param TagInterface $tag
     * @return \Doctrine\ORM\Query
     */
    public function getFindByTagQuery(TagInterface $tag);

    /**
     * @param CategoryInterface|null $category
     * @return int
     */
    public function getCountByCategory(CategoryInterface $category = null);
}
