<?php

namespace Dmitxe\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction($page = 1)
    {
        return $this->render('DmitxeSiteBundle:Page:index.html.twig', ['page' =>$page]);
    }

    public function aboutAction()
    {
        return $this->render('DmitxeSiteBundle:Page:about.html.twig');
    }
}
