<?php

namespace SmartCore\Bundle\BlogBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use SmartCore\Bundle\BlogBundle\Model\CategoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Routing\RouterInterface;

class CategoryService extends AbstractBlogService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var EntityRepository
     */
    protected $categoriesRepo;

    /**
     * @param EntityManager $em
     * @param RouterInterface $router
     * @param int $itemsPerPage
     */
    public function __construct(EntityManager $em, $itemsPerPage = 10)
    {
        $this->em                 = $em;
        $this->categoriesRepo     = $em->getRepository('DmitxeBlogBundle:Category'); // @todo внедрение имени класса категории
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
     * @return CategoryInterface[]|null
     */
    public function all()
    {
        return $this->categoriesRepo->findAll();
    }
}
