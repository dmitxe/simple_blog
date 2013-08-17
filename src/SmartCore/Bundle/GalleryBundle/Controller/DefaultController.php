<?php

namespace SmartCore\Bundle\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SmartGalleryBundle:Default:index.html.twig');
    }
}
