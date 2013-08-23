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
        /** @var \SmartCore\Bundle\BlogBundle\Service\CategoryService $categoryService */
        $categoryService = $this->get($this->categoryServiceName);

        return $this->render($this->bundleName . ':Widget:category_list.html.twig', [
            'categories' => $categoryService->all(),
        ]);
     }
}
