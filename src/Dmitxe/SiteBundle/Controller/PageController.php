<?php

namespace Dmitxe\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function aboutAction()
    {
        return $this->render('DmitxeSiteBundle:Page:about.html.twig');
    }
}
