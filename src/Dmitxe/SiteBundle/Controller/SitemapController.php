<?php

namespace Dmitxe\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SitemapController extends Controller
{
    public function xmlAction()
    {
        $changefreq = 'weekly';
        $items = [];
        $item = [];
        // Статичные страницы
        $item['url'] = $this->generateUrl('dmitxe_site_index');
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
}
