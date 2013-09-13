<?php

namespace Dmitxe\NewsBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class AdminMenu extends ContainerAware
{
    /**
     * @param FactoryInterface $factory
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    public function main(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('dmitxe_news_admin');

        $menu->setChildrenAttribute('class', isset($options['class']) ? $options['class'] : 'nav nav-pills');

        $menu->addChild('Articles',     ['route' => 'dmitxe_news_admin_article']);
        $menu->addChild('Tags',         ['route' => 'dmitxe_news_admin_tag']);

        return $menu;
    }
}
