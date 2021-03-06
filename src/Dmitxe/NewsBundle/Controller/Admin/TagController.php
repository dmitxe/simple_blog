<?php

namespace Dmitxe\NewsBundle\Controller\Admin;

use SmartCore\Bundle\BlogBundle\Controller\Admin\TagController as BaseTagController;

class TagController extends BaseTagController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->bundleName           = 'DmitxeNewsBundle';

        $this->tagCreateForm        = 'dmitxe_news.tag.create.form.type';
        $this->tagEditForm          = 'dmitxe_news.tag.edit.form.type';
        $this->tagServiceName       = 'dmitxe_news.tag';
        $this->routeIndex           = 'dmitxe_news_tag_index';
        $this->routeAdminTag        = 'dmitxe_news_admin_tag';
        $this->routeAdminTagEdit    = 'dmitxe_news_admin_tag_edit';
    }
}
