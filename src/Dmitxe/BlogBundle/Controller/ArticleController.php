<?php

namespace Dmitxe\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use SmartCore\Bundle\BlogBundle\Controller\ArticleController as BaseArticleController;
use SmartCore\Bundle\BlogBundle\Form\Type\ArticleFormType;

class ArticleController extends BaseArticleController
{
    /**
     * Метод createAction в данном случае перегражается только для того, чтобы вставить $article->setAuthor($this->getUser());
     *
     * @todo сделать события в формах и через него добавлять пользователя.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        /** @var \Dmitxe\BlogBundle\Entity\Article $article */
        $article = $this->get('smart_blog.article')->create();

        $form = $this->createForm(new ArticleFormType(get_class($article)), $article);

        if ($request->isMethod('POST')) {
            $form->submit($request);

            if ($form->isValid()) {
                $article = $form->getData();
                $article->setAuthor($this->getUser());

                /** @var \Doctrine\ORM\EntityManager $em */
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                return $this->redirect($this->generateUrl('smart_blog_article', ['slug' => $article->getSlug()] ));
            }
        }

        return $this->render('SmartBlogBundle:Article:create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
