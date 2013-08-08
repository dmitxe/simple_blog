<?php

namespace SmartCore\Bundle\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;
use SmartCore\Bundle\BlogBundle\Model\TagInterface;

class TagRepository extends EntityRepository
{
    /**
     * @param TagInterface $tag
     * @return int
     *
     * @todo возможность выбора по нескольким тэгам.
     */
    public function getArticlesCountByTag(TagInterface $tag)
    {
        $query = $this->_em->createQuery("
            SELECT COUNT(a.id)
            FROM {$this->_entityName} AS t
            JOIN t.articles AS a
            WHERE t = :tag
            AND a.enabled = true
        ")->setParameter('tag', $tag);

        return $query->getSingleScalarResult();
    }

    /**
     * @param TagInterface $tag
     * @return int
     *
     * @todo возможность выбора по нескольким тэгам.
     * @todo убрать в репу TagRepository
     */
    public function getCountByTag(TagInterface $tag)
    {
        $query = $this->_em->createQuery("
            SELECT COUNT(a.id)
            FROM {$this->_entityName} AS t
            JOIN t.articles AS a
            WHERE t = :tag
            AND a.enabled = true
        ")->setParameter('tag', $tag);

        return $query->getSingleScalarResult();
    }
}
