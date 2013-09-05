<?php

namespace Dmitxe\BlogBundle\Controller;

use SmartCore\Bundle\BlogBundle\Controller\ArticleController as BaseController;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\Pagerfanta;
use SmartCore\Bundle\BlogBundle\Pagerfanta\SimpleDoctrineORMAdapter;
use Symfony\Component\HttpFoundation\Response;

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
        $this->bundleName           = 'DmitxeBlogBundle';

        $this->articleServiceName   = 'smart_blog.article';
        $this->routeIndex           = 'smart_blog_index';
        $this->routeArticle         = 'smart_blog_article';
    }

    /**
     * @param int $page
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function indexAction($page = 1)
    {
        /** @var \SmartCore\Bundle\BlogBundle\Service\ArticleService $articleService */
        $articleService = $this->get($this->articleServiceName);

        $pagerfanta = new Pagerfanta(new SimpleDoctrineORMAdapter($articleService->getFindByCategoryQuery()));
        $pagerfanta->setMaxPerPage($articleService->getItemsCountPerPage());

        try {
            $pagerfanta->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            return $this->redirect($this->generateUrl($this->routeIndex));
        }

        $response = new Response();
        $content = $this->renderView($this->bundleName . ':Article:simple_list.html.twig', [
                       'pagerfanta' => $pagerfanta,
                   ]);
        $response->setContent($content);
        return $response;

        //       return $this->renderView($this->bundleName . ':Article:simple_list.html.twig', [
 //           'pagerfanta' => $pagerfanta,
 //       ]);
    }

}
