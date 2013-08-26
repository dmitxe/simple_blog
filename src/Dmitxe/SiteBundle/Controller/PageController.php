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
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Главная", $this->get("router")->generate("dmitxe_site_index"));
        $breadcrumbs->addItem("О сайте");

        return $this->render('DmitxeSiteBundle:Page:about.html.twig');
    }

    public function contactsAction()
    {
        return $this->render('DmitxeSiteBundle:Page:contacts.html.twig');
    }
}
