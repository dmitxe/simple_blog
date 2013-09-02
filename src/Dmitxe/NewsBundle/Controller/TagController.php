<?php

namespace Dmitxe\NewsBundle\Controller;

use SmartCore\Bundle\BlogBundle\Controller\TagController as BaseTagController;

class TagController extends BaseTagController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->bundleName       = 'DmitxeNewsBundle';

        $this->tagServiceName   = 'dmitxe_news.tag';
        $this->routeIndex       = 'dmitxe_news_tag_index';
        $this->routeTag         = 'dmitxe_news_tag';
    }
}
