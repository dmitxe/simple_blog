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
        $menu->setChildrenAttribute('class', isset($options['class']) ? $options['class'] : 'nav');
        $menu->addChild('Blog',         ['route' => 'smart_blog.article.index']);
        $menu->addChild('О сайте',      ['route' => 'dmitxe_site_about']);
        $menu->addChild('Контакты',     ['route' => 'mremi_contact_form']);
        $menu->addChild('News',         ['route' => 'dmitxe_news_index']);
        $menu->addChild('Gallery',      ['route' => 'smart_gallery_index']);
        $menu->addChild('Карта сайта',  ['route' => 'dmitxe_sitemap_html']);

        if (true === $this->container->get('security.context')->isGranted('ROLE_BLOGGER')) {
            $menu->addChild('Create Article', ['route' => 'smart_blog.article.create']);
        }

        if (true === $this->container->get('security.context')->isGranted('ROLE_NEWSMAKER')) {
            $menu->addChild('Create News', ['route' => 'dmitxe_news_article_create']);
        }

        if (true === $this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
            $menu->addChild('Admin', ['route' => 'dmitxe_site_admin']);
        }

        return $menu;
    }
}
