<?php

namespace Dmitxe\NewsBundle\Controller\Admin;

use SmartCore\Bundle\BlogBundle\Controller\Admin\ArticleController as BaseArticleController;

class ArticleController extends BaseArticleController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->articleServiceName    = 'dmitxe_news.article';
        $this->routeAdminArticle     = 'dmitxe_news_admin_index';
        $this->routeAdminArticleEdit = 'dmitxe_news_admin_edit';
        $this->bundleName            = 'DmitxeNewsBundle';
    }
}
