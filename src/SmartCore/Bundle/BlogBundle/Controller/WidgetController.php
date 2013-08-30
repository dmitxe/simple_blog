<?php

namespace SmartCore\Bundle\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @todo наследуемость как контроллеры статей и тэгов.
 */
class WidgetController extends Controller
{
    /**
     * Имя бандла. Для перегрузки шаблонов.
     *
     * @var string
     */
    protected $bundleName;

    /**
     * Имя сервиса по работе с категориями.
     *
     * @var string
     */
    protected $categoryServiceName;

    /**
     * Имя сервиса по работе со статьями.
     *
     * @var string
     */
    protected $articleServiceName;

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
        $this->bundleName           = 'SmartBlogBundle';

        $this->articleServiceName   = 'smart_blog.article';
        $this->categoryServiceName  = 'smart_blog.category';
        $this->tagServiceName       = 'smart_blog.tag';
        $this->routeTag             = 'smart_blog_tag';
    }

    /**
     * @param integer $limit
     * @return Response
     */
    public function archiveArticlesAction($limit = 24)
    {
        /** @var \SmartCore\Bundle\BlogBundle\Service\ArticleService $articleService */
        $articleService = $this->get($this->articleServiceName);
        $articles = $articleService->monthlyArchives($limit);
        return $this->render($this->bundleName . ':Widget:archive_articles.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @return Response
     */
    public function categoryTreeAction()
    {
        /** @var \SmartCore\Bundle\BlogBundle\Service\CategoryService $categoryService */
        $categoryService = $this->get($this->categoryServiceName);
        $category = $categoryService->create();

        return $this->render($this->bundleName . ':Widget:category_tree.html.twig', [
            'categoryClass' => get_class($category),
        ]);
    }

    /**
     * @return Response
     */
    public function tagCloudAction()
    {
        $cloud = $this->get('smart_blog.cache')->fetch($this->bundleName . 'tag_cloud_zend');

        if (false === $cloud) {
            /** @var \SmartCore\Bundle\BlogBundle\Service\TagService $tagService */
            $tagService = $this->get($this->tagServiceName);

            $cloud = $tagService->getCloudZend($this->routeTag)->render();
            $this->get('smart_blog.cache')->save($this->bundleName . 'tag_cloud_zend', $cloud);
        }

        return new Response($cloud);
    }
}
