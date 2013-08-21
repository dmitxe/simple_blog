<?php

namespace SmartCore\Bundle\BlogBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use SmartCore\Bundle\BlogBundle\Model\CategoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Routing\RouterInterface;
use SmartCore\Bundle\BlogBundle\SmartBlogBundle;
use SmartCore\Bundle\BlogBundle\SmartBlogEvents;

class CategoryService extends AbstractBlogService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var \SmartCore\Bundle\BlogBundle\Repository\CategoryRepository
     */
    protected $categoriesRepo;

    /**
     * @param EntityManager $em
     * @param RouterInterface $router
     * @param int $itemsPerPage
     */
    public function __construct(
        EntityManager $em,
        RouterInterface $router,
        $itemsPerPage = 10)
    {
        $this->em               = $em;
        $this->router           = $router;
        $this->categoriesRepo     = $em->getRepository('SmartBlogBundle:Category');
        $this->setItemsCountPerPage($itemsPerPage);
    }

    /**
     * @param int $id
     * @return CategoryInterface|null
     */
    public function get($id)
    {
        return $this->categoriesRepo->find($id);
    }

    /**
     * @return CategoryInterface
     */
    public function create()
    {
        $class = $this->categoriesRepo->getClassName();

        $category = new $class('');

        return $category;
    }

    /**
     * @param CategoryInterface $category
     */
    public function update(CategoryInterface $category)
    {
        $this->em->persist($category);
        $this->em->flush($category);
    }

    /**
     * @return \Doctrine\ORM\Query
     */
    public function getFindAllQuery()
    {
        return $this->categoriesRepo->getFindAllQuery();
    }
}
