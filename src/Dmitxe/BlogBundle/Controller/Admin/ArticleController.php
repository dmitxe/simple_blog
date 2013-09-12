<?php

namespace Dmitxe\BlogBundle\Controller\Admin;

use SmartCore\Bundle\BlogBundle\Controller\Admin\ArticleController as BaseController;

class ArticleController extends BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->articleEditForm  = 'dmitxe_blog.article.edit.form.type';
    }
}
