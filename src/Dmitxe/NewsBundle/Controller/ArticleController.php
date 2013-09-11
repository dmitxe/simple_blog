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
        $this->bundleName               = 'DmitxeNewsBundle';

        $this->articleCreateFormFactory = 'dmitxe_news.article.create.form.factory';
        $this->articleEditFormFactory   = 'dmitxe_news.article.edit.form.factory';
        $this->articleServiceName       = 'dmitxe_news.article';
        $this->routeIndex               = 'dmitxe_news_index';
        $this->routeArticle             = 'dmitxe_news_article';
    }
}
