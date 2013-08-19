<?php

namespace SmartCore\Bundle\TexterBundle\Service;

abstract class AbstractBlogService
{
    /**
     * @var \SmartCore\Bundle\TexterBundle\Repository\TexterRepository
     */
    protected $textersRepo;

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
