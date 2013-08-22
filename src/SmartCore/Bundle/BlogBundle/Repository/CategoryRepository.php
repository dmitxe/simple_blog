<?php

namespace SmartCore\Bundle\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;
use SmartCore\Bundle\BlogBundle\Model\CategoryInterface;

class CategoryRepository extends EntityRepository
{

    /**
     * @return \Doctrine\ORM\Query
     */
    public function getFindAllQuery()
    {
        return $this->_em->createQuery("
          SELECT categories
          FROM {$this->_entityName} AS categories
          ORDER BY categories.id DESC
        ");
    }
}
