<?php

namespace Dmitxe\NewsBundle\Controller;

use SmartCore\Bundle\BlogBundle\Controller\ArticleController as BaseArticleController;

class ArticleController extends BaseArticleController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->articleServiceName   = 'dmitxe_news.article';
        $this->routeIndex           = 'dmitxe_news_index';
        $this->routeArticle         = 'dmitxe_news_article';
        $this->bundleName           = 'DmitxeNewsBundle';
    }

    public function showAction($slug)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Главная", $this->get("router")->generate("dmitxe_site_index"));
        $breadcrumbs->addItem("Новости", $this->get("router")->generate("dmitxe_news_index"));
        $breadcrumbs->addItem("Просмотр новости");
        // ToDO: надо вывести заголовок новости. Не делая запроса к базе даных
        $response = parent::showAction($slug);
        return $response;
    }

    public function pageAction($page = 1)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Главная", $this->get("router")->generate("dmitxe_site_index"));
        $breadcrumbs->addItem("Новости");

        $response = parent::pageAction($page);
        return $response;
    }
}