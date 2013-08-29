<?php

namespace Dmitxe\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('@DmitxeSite/Admin/index.html.twig');
    }

    public function adminBlogAction()
    {
        return $this->redirect($this->generateUrl('smart_blog_admin_article'));
    }
}
