<?php

namespace SmartCore\Bundle\BlogBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use SmartCore\Bundle\BlogBundle\Model\CategoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @todo наследуемость как контроллеры статей и тэгов.
 */
class CategoryController extends Controller
{
    /**
     * Имя бандла. Для перегрузки шаблонов.
     *
     * @var string
     */
    protected $bundleName;

    /**
     * Маршрут на список категорий.
     *
     * @var string
     */
    protected $routeIndex;

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
        $this->categoryServiceName  = 'smart_blog.category';
        $this->routeIndex           = 'smart_blog_category_index';
        $this->bundleName           = 'SmartBlogBundle';
    }

    /**
     * @param string $slug
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @todo постраничность.
     */
    public function indexAction($slug = null)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $categoriesRepo = $em->getRepository('DmitxeBlogBundle:Category'); // @todo прокидывать имя класса категорий.

        $requestedCategories = [];
        $parent = null;
        foreach (explode('/', $slug) as $categoryName) {

            if (strlen($categoryName) == 0) {
                break;
            }

            $category = $categoriesRepo->findOneBy([
                'parent' => $parent,
                'slug'   => $categoryName,
            ]);

            if ($category) {
                $requestedCategories[] = $category;
                $parent = $category;
            } else {
                throw $this->createNotFoundException();
            }
        }

        /** @var CategoryInterface $lastCategory */
        $lastCategory = end($requestedCategories);

        $categories = new ArrayCollection();
        $categories->add($lastCategory);

        $this->addChild($categories, $lastCategory);

        $articleService = $this->get('smart_blog.article');

        $articles = $articleService->getByCategories($categories->getValues());

        return $this->render('SmartBlogBundle:Category:articles.html.twig', [
            'articles'      => $articles,
            'categories'    => $requestedCategories,
            'lastCategory'  => $lastCategory,
        ]);
    }

    /**
     * Получение всех вложенных категорий.
     *
     * @param ArrayCollection $categories
     * @param CategoryInterface $parent
     */
    protected function addChild(ArrayCollection $categories, CategoryInterface $parent = null)
    {
        if (null === $parent) {
            return;
        } else {
            $children = $parent->getChildren();
        }

        /** @var CategoryInterface $category */
        foreach ($children as $category) {
            $categories->add($category);
            $this->addChild($categories, $category);
        }
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showSimpleListAction()
    {
        /** @var \SmartCore\Bundle\BlogBundle\Service\CategoryService $categoryService */
        $categoryService = $this->get($this->categoryServiceName);

        return $this->render($this->bundleName . ':Category:simple_list.html.twig', [
            'categories' => $categoryService->all(),
        ]);
    }
}
