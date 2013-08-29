<?php

namespace SmartCore\Bundle\BlogBundle\Service;

use Doctrine\Common\Cache\Cache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use SmartCore\Bundle\BlogBundle\Model\CategoryInterface;
use Symfony\Component\Routing\RouterInterface;

class CategoryService extends AbstractBlogService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var EntityRepository
     */
    protected $categoriesRepo;

    /**
     * @param EntityManager $em
     * @param RouterInterface $router
     * @param int $itemsPerPage
     */
    public function __construct(EntityManager $em, EntityRepository $categoriesRepo, Cache $cache, $itemsPerPage = 10)
    {
        $this->cache              = $cache;
        $this->categoriesRepo     = $categoriesRepo;
        $this->em                 = $em;

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

        $cacheKey = md5('knp_menu_category_tree' . get_class($category));
        $this->cache->delete($cacheKey);
    }

    /**
     * @return CategoryInterface[]|null
     */
    public function all()
    {
        return $this->categoriesRepo->findAll();
    }

    /**
     * @return CategoryInterface[]|null
     */
    public function getRoots()
    {
        return $this->categoriesRepo->findBy(['parent' => null]);
    }
}
