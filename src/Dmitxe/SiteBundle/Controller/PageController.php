<?php

namespace Dmitxe\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction()
    {
        return $this->render('DmitxeSiteBundle:Page:index.html.twig');
    }

    public function aboutAction()
    {
        return $this->render('DmitxeSiteBundle:Page:about.html.twig');
    }

    public function contactsAction()
    {
        return $this->render('DmitxeSiteBundle:Page:contacts.html.twig');
    }
}
