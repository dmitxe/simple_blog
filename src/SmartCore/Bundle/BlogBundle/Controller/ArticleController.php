<?php

namespace SmartCore\Bundle\BlogBundle\Controller;

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
        $this->bundleName           = 'SmartBlogBundle';

        $this->articleServiceName   = 'smart_blog.article';
        $this->routeIndex           = 'smart_blog_index';
        $this->routeArticle         = 'smart_blog_article';
    }

    /**
     * @param string $slug
     * @return Response
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction($slug)
    {
        $article = $this->get($this->articleServiceName)->getBySlug($slug);

        if (!$article) {
            throw $this->createNotFoundException();
        }

        return $this->render($this->bundleName . ':Article:show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @return Response
     */
    public function indexAction()
    {
        /** @var \SmartCore\Bundle\BlogBundle\Service\ArticleService $articleService */
        $articleService = $this->get($this->articleServiceName);

        $pagerfanta = new Pagerfanta(new SimpleDoctrineORMAdapter($articleService->getFindByCategoryQuery()));
        $pagerfanta->setMaxPerPage($articleService->getItemsCountPerPage());
        $pagerfanta->setCurrentPage(1);

        return $this->render($this->bundleName . ':Article:list.html.twig', [
            'pagerfanta' => $pagerfanta,
        ]);
    }

    /**
     * @param int $page
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function pageAction($page = 1)
    {
        if ($page == 1) {
            return $this->redirect($this->generateUrl($this->routeIndex));
        }

        /** @var \SmartCore\Bundle\BlogBundle\Service\ArticleService $articleService */
        $articleService = $this->get($this->articleServiceName);

        $pagerfanta = new Pagerfanta(new SimpleDoctrineORMAdapter($articleService->getFindByCategoryQuery()));
        $pagerfanta->setMaxPerPage($articleService->getItemsCountPerPage());

        try {
            $pagerfanta->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            return $this->redirect($this->generateUrl($this->routeIndex));
        }

        return $this->render($this->bundleName . ':Article:list.html.twig', [
            'pagerfanta' => $pagerfanta,
        ]);
    }

    /**
     * @param Request $requst
     * @param integer $year
     * @param integer $month
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function archiveMonthlyAction(Request $requst, $year = 1970, $month = 1)
    {
        /** @var \SmartCore\Bundle\BlogBundle\Service\ArticleService $articleService */
        $articleService = $this->get($this->articleServiceName);

        $firstDate = new \Datetime($year . '-' . $month . '-1');
        $lastDate  = clone $firstDate;
        $lastDate->modify('+1 month');

        $pagerfanta = new Pagerfanta(new SimpleDoctrineORMAdapter($articleService->getFindByDateQuery($firstDate, $lastDate)));
        $pagerfanta->setMaxPerPage($articleService->getItemsCountPerPage());

        try {
            $pagerfanta->setCurrentPage($requst->query->get('page', 1));
        } catch (NotValidCurrentPageException $e) {
            return $this->redirect($this->generateUrl($this->routeIndex));
        }

        return $this->render($this->bundleName . ':Article:archive_list.html.twig', [
            'pagerfanta' => $pagerfanta,
            'year'       => $year,
            'month'      => $month,
        ]);
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
                $article = $form->getData();
                $articleService->update($article);

                return $this->redirect($this->generateUrl($this->routeArticle, ['slug' => $article->getSlug()] ));
            }
        }

        return $this->render($this->bundleName . ':Article:edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createAction(Request $request)
    {
        /** @var \SmartCore\Bundle\BlogBundle\Service\ArticleService $articleService */
        $articleService = $this->get($this->articleServiceName);
        $article        = $articleService->create();

        // @todo эксперименты с событиями.
//        $this->class = 'SmartCore\Bundle\BlogBundle\SmartBlogEvents';
        /** @var \SmartCore\Bundle\BlogBundle\Events $class */
//        $class = $this->class;

//        ld(\SmartCore\Bundle\BlogBundle\SmartBlogEvents::ARTICLE_CREATE);
//        ld($class::articleCreate());

        $form = $this->createForm(new ArticleCreateFormType(get_class($article)), $article);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $articleService->update($article, false);

                return $this->redirect($this->generateUrl($this->routeArticle, ['slug' => $article->getSlug()] ));
            }
        }

        return $this->render($this->bundleName . ':Article:create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
