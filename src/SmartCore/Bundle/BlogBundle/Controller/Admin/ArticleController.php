<?php

namespace SmartCore\Bundle\BlogBundle\Controller\Admin;

use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use SmartCore\Bundle\BlogBundle\Form\Type\ArticleCreateFormType;
use SmartCore\Bundle\BlogBundle\Form\Type\ArticleEditFormType;
use SmartCore\Bundle\BlogBundle\Pagerfanta\SimpleDoctrineORMAdapter;

class ArticleController extends Controller
{
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
    protected $routeAdminArticle;

    /**
     * Маршрут редактирования статьи.
     *
     * @var string
     */
    protected $routeAdminArticleEdit;

    /**
     * Имя бандла. Для перегрузки шаблонов.
     *
     * @var string
     */
    protected $bundleName;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->articleServiceName    = 'smart_blog.article';
        $this->routeAdminArticle     = 'smart_blog_admin_article';
        $this->routeAdminArticleEdit = 'smart_blog_admin_article_edit';
        $this->bundleName            = 'SmartBlogBundle';
    }

    /**
     * @param Request $requst
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function indexAction(Request $requst)
    {
        /** @var \SmartCore\Bundle\BlogBundle\Service\ArticleService $articleService */
        $articleService = $this->get($this->articleServiceName);

        $pagerfanta = new Pagerfanta(new SimpleDoctrineORMAdapter($articleService->getFindByCategoryQuery()));
        $pagerfanta->setMaxPerPage($articleService->getItemsCountPerPage());

        try {
            $pagerfanta->setCurrentPage($requst->query->get('page', 1));
        } catch (NotValidCurrentPageException $e) {
            return $this->redirect($this->generateUrl($this->routeIndex));
        }

        return $this->render($this->bundleName . ':Admin/Article:list.html.twig', [
            'pagerfanta' => $pagerfanta,
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function editAction(Request $request, $id)
    {
        /** @var \SmartCore\Bundle\BlogBundle\Model\ArticleInterface $article */
        $article = $this->get($this->articleServiceName)->get($id);

        if (null === $article) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new ArticleEditFormType(get_class($article)), $article);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $article = $form->getData();
                $article->setUpdated();

                /** @var \Doctrine\ORM\EntityManager $em */
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                return $this->redirect($this->generateUrl($this->routeAdminArticle));
            }
        }

        return $this->render($this->bundleName . ':Admin/Article:edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createAction(Request $request)
    {
        /** @var \SmartCore\Bundle\BlogBundle\Model\ArticleInterface $article */
        $article = $this->get($this->articleServiceName)->create();

        $form = $this->createForm(new ArticleCreateFormType(get_class($article)), $article);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $article = $form->getData();

                /** @var \Doctrine\ORM\EntityManager $em */
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                return $this->redirect($this->generateUrl($this->routeAdminArticle));
            }
        }

        return $this->render($this->bundleName . ':Admin/Article:create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
