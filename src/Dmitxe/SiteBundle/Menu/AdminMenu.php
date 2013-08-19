<?php

namespace Dmitxe\SiteBundle\Menu;

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
        $menu = $factory->createItem('site_admin_main');

        $menu->setChildrenAttribute('class', isset($options['class']) ? $options['class'] : 'nav nav-tabs');

        $menu->addChild('Blog',     ['route' => 'smart_blog_admin_article']);
        $menu->addChild('News',     ['route' => 'dmitxe_news_admin_index']);
        $menu->addChild('Texts',    ['route' => 'smart_texter_admin_index']);

        return $menu;
    }
}
