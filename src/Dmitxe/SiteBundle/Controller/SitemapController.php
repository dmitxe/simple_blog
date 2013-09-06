<?php

namespace Dmitxe\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use SmartCore\Bundle\BlogBundle\Model\CategoryInterface;

class SitemapController extends Controller
{
    public function xmlAction()
    {
        $changefreq = 'weekly';
        $items = [];
        $item = [];
        // Статичные страницы
        $item['url'] = $this->generateUrl('smart_blog_index');
        $item['lastmod'] = date('Y-m-d'); //@todo сделать где-то хранение даты
        $item['changefreq'] = 'always';
        $item['priority'] = '1.0';
        $items[] = $item;
        $item['url'] = $this->generateUrl('dmitxe_site_about');
        $item['lastmod'] = date('Y-m-d');
        $item['changefreq'] = $changefreq;
        $item['priority'] = '0.9';
        $items[] = $item;

        // Категории
        /** @var \SmartCore\Bundle\BlogBundle\Service\CategoryService $categoryService */
        $categoryService = $this->get('smart_blog.category');
        $categories = $categoryService->all();

        foreach ($categories as $category) {
            $item['url'] = $this->generateUrl('smart_blog_category', ['slug' => $category->getslugFull()]);
            $item['lastmod'] = date('Y-m-d');
            $item['changefreq'] = $changefreq;
            $item['priority'] = '0.8';
            $items[] = $item;
        }

        // Статьи
        /** @var \SmartCore\Bundle\BlogBundle\Service\ArticleService $articleService */
        $articleService = $this->get('smart_blog.article');
        $articles = $articleService->getFindByCategoryQuery()->getResult();

        foreach ($articles as $article) {
            $item['url'] = $this->generateUrl('smart_blog_article', ['slug' => $article->getSlug()]);
            $item['lastmod'] = $article->getCreatedAt()->format('Y-m-d');
            $item['changefreq'] = $changefreq;
            $item['priority'] = '0.8';
            $items[] = $item;
        }

        // Новости
        /** @var \SmartCore\Bundle\BlogBundle\Service\ArticleService $articleService */
        $articleService = $this->get('dmitxe_news.article');
        $articles = $articleService->getFindByCategoryQuery()->getResult();

        foreach ($articles as $article) {
            $item['url'] = $this->generateUrl('smart_blog_article', ['slug' => $article->getSlug()]);
            $item['lastmod'] = $article->getCreatedAt()->format('Y-m-d');
            $item['changefreq'] = $changefreq;
            $item['priority'] = '0.8';
            $items[] = $item;
        }

//        ld($articles);

        $response = new Response();
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/xml');
        $content = $this->renderView('DmitxeSiteBundle:Sitemap:sitemap.xml.twig', ['items' => $items]);
        $response->setContent($content);
        return $response;
 //       return $this->render('DmitxeSiteBundle:Sitemap:sitemap.xml.twig', ['items' => $items]);
    }

    public function htmlAction()
    {
        $items = [];
        $item = [];
        $item['url'] = $this->generateUrl('smart_blog_index');
        $item['title'] = 'Блог';
        $item['level'] = 0;
        $items[] = $item;
        // Категории
        /** @var \SmartCore\Bundle\BlogBundle\Service\CategoryService $categoryService */
        $categoryService = $this->get('smart_blog.category');
        $level = 1;
        $category = $categoryService->create();
        $categoryClass = get_class($category);
        $this->addChild($items, $level, null, $categoryClass);

        // Новости
        $item['url'] = $this->generateUrl('dmitxe_news_index');
        $item['title'] = 'Новости';
        $item['level'] = 0;
        $items[] = $item;

        /** @var \SmartCore\Bundle\BlogBundle\Service\ArticleService $articleService */
        $articleService = $this->get('dmitxe_news.article');
        $articles = $articleService->getFindByCategoryQuery()->getResult();

        foreach ($articles as $article) {
            $item['url'] = $this->generateUrl('smart_blog_article', ['slug' => $article->getSlug()]);
            $item['title'] = $article->getTitle();
            $item['level'] = 1;
            $items[] = $item;
        }

        $item['url'] = $this->generateUrl('dmitxe_site_about');
        $item['title'] = 'О сайте';
        $item['level'] = 0;
        $items[] = $item;
        $item['url'] = $this->generateUrl('mremi_contact_form');
        $item['title'] = 'Контакты';
        $item['level'] = 0;
        $items[] = $item;

        return $this->render('DmitxeSiteBundle:Sitemap:sitemap.html.twig', ['items' => $items]);
    }

    /**
     * Рекурсивное построение дерева.
     *
     * @param Array $menu
     * @param CategoryInterface|null $parent
     * @param string $categoryClass
     * @return void
     */
    protected function addChild(Array &$menu, &$level = 0, CategoryInterface $parent = null, $categoryClass)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->container->get('doctrine')->getManager();

        $categories = $parent
            ? $parent->getChildren()
            : $em->getRepository($categoryClass)->findBy(['parent' => null]);

        $router = $this->container->get('router');

        /** @var CategoryInterface $category */
        foreach ($categories as $category) {
            $item = [];
            $item['url'] = $router->generate('smart_blog_category', ['slug' => $category->getSlugFull()]);
            $item['title'] = $category->getTitle();
            $item['level'] = $level;
            $menu[] = $item;
            $level++;
            $this->addArticles($menu, $level, $category);
            $this->addChild($menu, $level, $category, $categoryClass);
            $level--;
        }
    }
    /**
     * Выборка статей в категории.
     *
     * @param Array $items
     * @param CategoryInterface|null $parent
     * @return void
     */
    protected function addArticles(Array &$items, &$level = 0, CategoryInterface $parent= null)
    {

        if (!is_null($parent))
        {
            /** @var \SmartCore\Bundle\BlogBundle\Service\ArticleService $articleService */
            $articleService = $this->get('smart_blog.article');
            $articles = $articleService->getByCategories([$parent]);
            foreach ($articles as $article) {
                $item['url'] = $this->generateUrl('smart_blog_article', ['slug' => $article->getSlug()]);
                $item['title'] = $article->getTitle();
                $item['level'] = $level;
                $items[] = $item;
            }
        }
    }
}
