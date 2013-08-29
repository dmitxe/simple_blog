<?php

namespace SmartCore\Bundle\BlogBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use SmartCore\Bundle\BlogBundle\Model\CategoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Category extends ContainerAware
{
    /**
     * @param FactoryInterface $factory
     * @param array $options
     * @return ItemInterface
     */
    public function tree(FactoryInterface $factory, array $options)
    {
        if (!isset($options['categoryCalass'])) {
            throw new \Exception('Надо указать categoryCalass в опциях');
        }

        $categoryCalass = $options['categoryCalass'];

        $cacheKey = md5('knp_menu_category_tree' . $categoryCalass);

        $menu = $this->container->get('smart_blog.cache')->fetch($cacheKey);

        if (false === $menu) {
            $menu = $factory->createItem('categories');
            $this->addChild($menu, null, $categoryCalass);
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
     * @return void
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
     * @param CategoryInterface|null $parent
     * @param string $categoryCalass
     * @return void
     */
    protected function addChild(ItemInterface $menu, CategoryInterface $parent = null, $categoryCalass)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->container->get('doctrine')->getManager();

        $categories = $parent
            ? $parent->getChildren()
            : $em->getRepository($categoryCalass)->findBy(['parent' => null]);

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

            $this->addChild($sub_menu, $category, $categoryCalass);
        }
    }

    /**
     * @param FactoryInterface $factory
     * @param array $options
     * @return ItemInterface
     */
    public function adminTree(FactoryInterface $factory, array $options)
    {
        if (!isset($options['categoryCalass'])) {
            throw new \Exception('Надо указать categoryCalass в опциях');
        }

        $categoryCalass = $options['categoryCalass'];

        $menu = $factory->createItem('categories');
        $this->addChildToAdminTree($menu, null, $categoryCalass);

        return $menu;
    }

    /**
     * Рекурсивное построение дерева для админки.
     *
     * @param ItemInterface $menu
     * @param CategoryInterface|null $parent
     * @param string $categoryCalass
     * @return void
     */
    protected function addChildToAdminTree(ItemInterface $menu, CategoryInterface $parent = null, $categoryCalass)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->container->get('doctrine')->getManager();

        $categories = $parent
            ? $parent->getChildren()
            : $em->getRepository($categoryCalass)->findBy(['parent' => null]);

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

            $this->addChildToAdminTree($sub_menu, $category, $categoryCalass);
        }
    }
}
