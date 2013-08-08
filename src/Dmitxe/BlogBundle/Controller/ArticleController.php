<?php

namespace Dmitxe\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use SmartCore\Bundle\BlogBundle\Controller\ArticleController as BaseArticleController;
use SmartCore\Bundle\BlogBundle\Form\Type\ArticleFormType;

class ArticleController extends BaseArticleController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createAction(Request $request)
    {
        $article = $this->get('smart_blog.article')->create();

        $form = $this->createForm(new ArticleFormType(get_class($article)), $article);

        if ($request->isMethod('POST')) {
            $form->submit($request);

            if ($form->isValid()) {
                /** @var \Dmitxe\BlogBundle\Entity\Article $article */
                $article = $form->getData();
                $article->setAuthor($this->getUser());

                /** @var \Doctrine\ORM\EntityManager $em */
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                return $this->redirect($this->generateUrl('smart_blog_article', ['slug' => $article->getSlug()] ));
            }
        }

        return $this->container->get('templating')->renderResponse('SmartBlogBundle::article_new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
