<?php

namespace SmartCore\Bundle\BlogBundle\Service;

abstract class AbstractBlogService
{
    /**
     * @var \SmartCore\Bundle\BlogBundle\Repository\ArticleRepository
     */
    protected $articlesRepo;

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var integer
     */
    protected $itemsPerPage;

    /**
     * @return int
     */
    public function getItemsCountPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * @param int $count
     * @return $this
     */
    public function setItemsCountPerPage($count)
    {
        $this->itemsPerPage = $count;

        return $this;
    }
}
