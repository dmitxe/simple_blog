<?php

namespace SmartCore\Bundle\BlogBundle\Controller;

use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\Pagerfanta;
use SmartCore\Bundle\BlogBundle\Pagerfanta\SimpleDoctrineORMAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zend\Tag\Cloud;

class TagController extends Controller
{
    /**
     * Имя бандла. Для перегрузки шаблонов.
     *
     * @var string
     */
    protected $bundleName;

    /**
     * Маршрут на список тэгов.
     *
     * @var string
     */
    protected $routeIndex;

    /**
     * Маршрут просмотра списка статей по тэгу.
     *
     * @var string
     */
    protected $routeTag;

    /**
     * Имя сервиса по работе с тэгами.
     *
     * @var string
     */
    protected $tagServiceName;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->tagServiceName   = 'smart_blog.tag';
        $this->routeIndex       = 'smart_blog_tag_index';
        $this->routeTag         = 'smart_blog_tag';
        $this->bundleName       = 'SmartBlogBundle';
    }

    /**
     * @return Response
     */
    public function indexAction()
    {
        /** @var \SmartCore\Bundle\BlogBundle\Service\TagService $tagService */
        $tagService = $this->get($this->tagServiceName);

        return $this->render($this->bundleName . ':Tag:list.html.twig', [
            'cloud' => $tagService->getCloud($this->routeTag),
        ]);
    }

    /**
     * @return Response
     */
    public function cloudAction()
    {
        /** @var \SmartCore\Bundle\BlogBundle\Service\TagService $tagService */
        $tagService = $this->get($this->tagServiceName);

        return new Response($tagService->getCloudZend($this->routeTag)->render());
    }

    /**
     * @param Request $requst
     * @param string $slug
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function showArticlesAction(Request $requst, $slug)
    {
        /** @var \SmartCore\Bundle\BlogBundle\Service\TagService $tagService */
        $tagService = $this->get($this->tagServiceName);

        $tag = $tagService->getBySlug($slug);

        $pagerfanta = new Pagerfanta(new SimpleDoctrineORMAdapter($tagService->getFindByTagQuery($tag)));
        $pagerfanta->setMaxPerPage($tagService->getItemsCountPerPage());

        try {
            $pagerfanta->setCurrentPage($requst->query->get('page', 1));
        } catch (NotValidCurrentPageException $e) {
            return $this->redirect($this->generateUrl($this->routeIndex));
        }

        return $this->render($this->bundleName . ':Tag:list_by_tag.html.twig', [
            'pagerfanta' => $pagerfanta,
            'tag'        => $tag,
        ]);
    }
}
