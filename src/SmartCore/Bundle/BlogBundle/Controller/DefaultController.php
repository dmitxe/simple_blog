<?php

namespace SmartCore\Bundle\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @todo удалить
 */
class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SmartBlogBundle::articles.html.twig', [
            'articles' => $this->get('smart_blog.article')->getLast(),
        ]);
    }
}
