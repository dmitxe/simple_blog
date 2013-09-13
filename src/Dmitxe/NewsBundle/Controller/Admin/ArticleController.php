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
        $this->bundleName            = 'DmitxeNewsBundle';

        $this->articleCreateForm     = 'dmitxe_news.article.create.form.type';
        $this->articleEditForm       = 'dmitxe_news.article.edit.form.type';
        $this->articleServiceName    = 'dmitxe_news.article';
        $this->routeAdminArticle     = 'dmitxe_news_admin_article';
        $this->routeAdminArticleEdit = 'dmitxe_news_admin_article_edit';
    }
}
