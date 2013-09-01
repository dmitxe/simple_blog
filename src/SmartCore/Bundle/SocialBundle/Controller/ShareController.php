<?php

namespace SmartCore\Bundle\SocialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShareController extends Controller
{
    public function indexAction($url)
    {
        return $this->render('SmartSocialBundle:Share:index.html.twig', array('url' => $url));
    }
}
