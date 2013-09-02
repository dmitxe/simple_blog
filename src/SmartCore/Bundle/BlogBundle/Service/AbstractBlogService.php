<?php

namespace SmartCore\Bundle\BlogBundle\Service;

use Doctrine\Common\Cache\Cache;

abstract class AbstractBlogService
{
    /**
     * @var \SmartCore\Bundle\BlogBundle\Repository\ArticleRepositoryInterface
     */
    protected $articlesRepo;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var integer
     */
    protected $itemsPerPage;

    /**
     * @return integer
     */
    public function getItemsCountPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * @param integer $count
     * @return $this
     */
    public function setItemsCountPerPage($count)
    {
        $this->itemsPerPage = $count;

        return $this;
    }
}
