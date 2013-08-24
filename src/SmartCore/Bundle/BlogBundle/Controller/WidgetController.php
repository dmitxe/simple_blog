<?php

namespace SmartCore\Bundle\BlogBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
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
     * Constructor.
     */
    public function __construct()
    {
        $this->categoryServiceName   = 'smart_blog.category';
        $this->bundleName            = 'SmartBlogBundle';
    }

    /**
     * @param integer $id_action
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showCategoryListAction($id_action = null)
    {
        $menuCategory = array();
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
    protected function addChildCategory(Array &$menu, &$level, CategoryInterface $parent = null)
    {
        /** @var \SmartCore\Bundle\BlogBundle\Service\CategoryService $categoryService */
        $categoryService = $this->get($this->categoryServiceName);
        $categories = $parent
            ? $parent->getChildren()
            : $categoryService->getRoots();

        $router = $this->container->get('router');

        /** @var CategoryInterface $category */
        foreach ($categories as $category) {
            $uri = $router->generate('smart_blog_category', ['slug' => $category->getSlugFull()]);
            $item = array();
            $item['id'] = $category->getId();
            $item['title'] = $category->getTitle();
            $item['slug'] = $category->getSlug();
            $item['level'] = $level;
            $item['uri'] = $uri;
            $menu[] = $item;

            /** @var ItemInterface $sub_menu */
            $level++;
            $this->addChildCategory($menu, $level, $category);
            $level--;
        }
    }


}
