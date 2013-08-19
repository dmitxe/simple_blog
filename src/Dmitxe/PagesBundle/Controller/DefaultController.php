<?php

namespace Dmitxe\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
//        $Twig->addExtension(new MyTwigExtension());
        return $this->render('DmitxePagesBundle:Default:index.html.twig', array('name' => $name));
    }
}
