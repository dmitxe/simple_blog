<?php

namespace Dmitxe\SiteBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class SiteMenu extends ContainerAware
{
    /**
     * @param FactoryInterface $factory
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    public function main(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('site_main');

        if (isset($options['class'])) {
            $menu->setChildrenAttribute('class', $options['class']);
        } else {
            $menu->setChildrenAttribute('class', 'nav');
        }

        $menu->addChild('Homepage', ['route' => 'dmitxe_site_index']);
        $title = 'Blog';

        if ($this->container->get('security.context')->isGranted('ROLE_BLOGGER')) {
            $blogSubmenu = $menu->addChild($title, [
                'route'      => 'smart_blog_index',
                'attributes' => ['class' => 'dropdown']
            ]);

            $blogSubmenu->setLinkAttributes([
                    'class'       => 'dropdown-toggle',
                    'data-toggle' => 'dropdown',
                    'role'        => 'button',
                    'id'          => 'mmi_finance'
                ])
                //->setLabel($title . ' <b class="caret"></b>')->setExtra('safe_label', true)
                //->setLabel($title, true)
                ->setChildrenAttributes([
                    'class'           => 'dropdown-menu',
                    'role'            => 'menu',
                    'aria-labelledby' => 'mmi_finance']);

            $blogSubmenu->addChild('Все записи',    ['route' => 'smart_blog_index']);
            $blogSubmenu->addChild(null,            ['attributes' => ['class' => 'divider']]);
            $blogSubmenu->addChild('Новая запись',  ['route' => 'smart_blog_article_new']);
        } else {
            $menu->addChild($title, ['route' => 'smart_blog_index']);
        }

        return $menu;
    }
}
