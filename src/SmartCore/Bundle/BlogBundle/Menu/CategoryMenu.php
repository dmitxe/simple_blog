<?php

namespace SmartCore\Bundle\BlogBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use SmartCore\Bundle\BlogBundle\Model\CategoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class CategoryMenu extends ContainerAware
{
    /**
     * @param FactoryInterface $factory
     * @param array $options
     * @return ItemInterface
     */
    public function full(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('categories');

        $this->addChild($menu);

        return $menu;
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

        if (null == $parent) {
            // @todo внедрение имени класса категорий.
            $categories = $em->getRepository('DmitxeBlogBundle:Category')->findBy(['parent' => null]);
        } else {
            $categories = $parent->getChildren();
        }

        $router = $this->container->get('router');

        /** @var CategoryInterface $category */
        foreach ($categories as $category) {
            $uri = $router->generate('smart_blog_category', ['slug' => $category->getSlugFull()]);
            $menu->addChild($category->getTitle(), ['uri' => $uri])->setAttributes([
                'class' => 'folder',
                //'title' => $folder->getDescr(),
                'id' => 'category_id_' . $category->getId(),
            ]);

            /** @var ItemInterface $sub_menu */
            $sub_menu = $menu[$category->getTitle()];

            $this->addChild($sub_menu, $category);
        }
    }
}
