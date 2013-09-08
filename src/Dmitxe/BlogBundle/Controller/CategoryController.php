<?php

namespace Dmitxe\BlogBundle\Controller;

use SmartCore\Bundle\BlogBundle\Controller\CategoryController as BaseController;

class CategoryController extends BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->bundleName = 'DmitxeBlogBundle';
    }
}
