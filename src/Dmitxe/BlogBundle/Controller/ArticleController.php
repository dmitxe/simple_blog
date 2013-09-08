<?php

namespace Dmitxe\BlogBundle\Controller;

use Dmitxe\BlogBundle\Entity\Article;
use Dmitxe\BlogBundle\Form\Type\ArticleEditFormType;
use SmartCore\Bundle\BlogBundle\Controller\ArticleController as BaseController;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends BaseController
{
    /**
     * Имя бандла. Для перегрузки шаблонов.
     *
     * @var string
     */
    protected $bundleName;

    /**
     * Имя сервиса по работе со статьями.
     *
     * @var string
     */
    protected $articleServiceName;

    /**
     * Маршрут на список статей.
     *
     * @var string
     */
    protected $routeIndex;

    /**
     * Маршрут просмотра статьи.
     *
     * @var string
     */
    protected $routeArticle;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->bundleName = 'DmitxeBlogBundle';
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function editAction(Request $request, $id)
    {
        /** @var \SmartCore\Bundle\BlogBundle\Service\ArticleService $articleService */
        $articleService = $this->get($this->articleServiceName);

        $article = $articleService->get($id);

        if (null === $article) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new ArticleEditFormType(get_class($article)), $article);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                /** @var Article $article */
                $article = $form->getData();
                // @todo пока тут будет обработка загруженной картинки.
                // ldd($article->getImage());

                $articleService->update($article);

                return $this->redirect($this->generateUrl($this->routeArticle, ['slug' => $article->getSlug()] ));
            }
        }

        return $this->render('SmartBlogBundle:Article:edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
