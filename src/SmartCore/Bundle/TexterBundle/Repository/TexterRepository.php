<?php

namespace SmartCore\Bundle\TexterBundle\Repository;

use Doctrine\ORM\EntityRepository;
use SmartCore\Bundle\TexterBundle\Model\TexterInterface;

class TexterRepository extends EntityRepository
{
    /**
     * @return \Doctrine\ORM\Query
     */
    public function getFindAllQuery()
    {
        return $this->_em->createQuery("
          SELECT text_items
          FROM {$this->_entityName} AS texters
          ORDER BY texters.id DESC
        ");
    }
}
