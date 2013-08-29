<?php

namespace SmartCore\Bundle\BlogBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use SmartCore\Bundle\BlogBundle\Model\CategoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Category extends ContainerAware
{
    /**
     * @var string
     */
    protected $categoryCalass = 'Dmitxe\BlogBundle\Entity\Category'; // @todo внедрение имени класса категорий.

    /**
     * @param FactoryInterface $factory
     * @param array $options
     * @return ItemInterface
     */
    public function tree(FactoryInterface $factory, array $options)
    {
        $cacheKey = md5('knp_menu_category_tree' . $this->categoryCalass);

        $menu = $this->container->get('smart_blog.cache')->fetch($cacheKey);

        if (false === $menu) {
            $menu = $factory->createItem('categories');
            $this->addChild($menu);
            $this->removeFactory($menu);

            // @todo настройка времени хранения кеша и инвалидация.
            $this->container->get('smart_blog.cache')->save($cacheKey, $menu, 3000);
        }

        return $menu;
    }

    /**
     * Рекурсивный метод для удаления фабрики, что позволяет кешировать объект меню.
     *
     * @param ItemInterface $menu
     */
    protected function removeFactory(ItemInterface $menu)
    {
        $menu->setFactory(new DummyFactory());

        foreach ($menu->getChildren() as $subMenu) {
            $this->removeFactory($subMenu);
        }
    }

    /**
     * Рекурсивное построение дерева.
     *
     * @param ItemInterface $menu
     * @param CategoryInterface $parent
     */
    protected function addChild(ItemInterface $menu, CategoryInterface $parent = null)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->container->get('doctrine')->getManager();

        $categories = $parent
            ? $parent->getChildren()
            : $em->getRepository($this->categoryCalass)->findBy(['parent' => null]);

        $router = $this->container->get('router');

        /** @var CategoryInterface $category */
        foreach ($categories as $category) {
            $uri = $router->generate('smart_blog_category', ['slug' => $category->getSlugFull()]);
            $menu->addChild($category->getTitle(), ['uri' => $uri])
                ->setAttributes([
                    'class' => 'folder',
                    'id'    => 'category_id_' . $category->getId(),
                ]);

            /** @var ItemInterface $sub_menu */
            $sub_menu = $menu[$category->getTitle()];

            $this->addChild($sub_menu, $category);
        }
    }

    /**
     * @param FactoryInterface $factory
     * @param array $options
     * @return ItemInterface
     */
    public function adminTree(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('categories');

        $this->addChildToAdminTree($menu);

        return $menu;
    }

    /**
     * Рекурсивное построение дерева для админки.
     *
     * @param ItemInterface $menu
     * @param CategoryInterface $parent
     */
    protected function addChildToAdminTree(ItemInterface $menu, CategoryInterface $parent = null)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->container->get('doctrine')->getManager();

        $categories = $parent
            ? $parent->getChildren()
            : $em->getRepository($this->categoryCalass)->findBy(['parent' => null]);

        $router = $this->container->get('router');

        /** @var CategoryInterface $category */
        foreach ($categories as $category) {
            $uri = $router->generate('smart_blog_admin_category_edit', ['id' => $category->getId()]);
            $menu->addChild($category->getTitle(), ['uri' => $uri])
                ->setAttributes([
                    'class' => 'folder',
                    'id'    => 'category_id_' . $category->getId(),
                ]);

            /** @var ItemInterface $sub_menu */
            $sub_menu = $menu[$category->getTitle()];

            $this->addChildToAdminTree($sub_menu, $category);
        }
    }
}
