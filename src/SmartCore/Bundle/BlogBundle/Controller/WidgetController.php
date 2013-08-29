<?php

namespace SmartCore\Bundle\BlogBundle\Controller;

use SmartCore\Bundle\BlogBundle\Model\CategoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
     * Constructor.
     */
    public function __construct()
    {
        $this->categoryServiceName  = 'smart_blog.category';
        $this->articleServiceName   = 'smart_blog.article';
        $this->bundleName           = 'SmartBlogBundle';
    }

    /**
     * @param integer $limit
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function archiveArticlesAction($limit = 10)
    {
        /** @var \SmartCore\Bundle\BlogBundle\Service\ArticleService $articleService */
        $articleService = $this->get($this->articleServiceName);
        $articles = $articleService->getFindLastByDate($limit);
        $yearmonth = [];
        $count = 0;
        foreach ($articles as $article) {
            $ym = $article->getCreatedAt()->format('F Y'); // December 2011
            if (!isset($yearmonth[$ym])) {
                if (++$count > $limit) break;
                $yearmonth[$ym] = 1;
            } else {
                $yearmonth[$ym]++;  // 2, 3, 4
            }
        }

        return $this->render($this->bundleName . ':Widget:archive_articles.html.twig', [
            'articles' => $yearmonth,
       ]);
    }

    /**
     * @param integer $id_action
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoryListAction()
    {
        $menuCategory = [];
        $level = 1;
        $this->addChildCategory($menuCategory, $level);

        return $this->render($this->bundleName . ':Widget:category_list.html.twig', [
            'categories' => $menuCategory,
        ]);
    }

    /**
     * Рекурсивное построение дерева.
     *
     * @param Array $menu
     * @param integer $level
     * @param CategoryInterface $parent
     */
    protected function addChildCategory(array &$menu, &$level, CategoryInterface $parent = null)
    {
        $categories = $parent
            ? $parent->getChildren()
            : $this->get($this->categoryServiceName);

        $router = $this->container->get('router');

        /** @var CategoryInterface $category */
        foreach ($categories as $category) {
            $menu[] = [
                'id'    => $category->getId(),
                'title' => $category->getTitle(),
                'slug'  => $category->getSlug(),
                'level' => $level,
                'uri'   => $router->generate('smart_blog_category', ['slug' => $category->getSlugFull()]),
            ];

            $level++;
            $this->addChildCategory($menu, $level, $category);
            $level--;
        }
    }
}
