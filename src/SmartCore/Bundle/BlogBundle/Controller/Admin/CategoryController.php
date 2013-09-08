<?php

namespace SmartCore\Bundle\BlogBundle\Controller\Admin;

use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\Pagerfanta;
use SmartCore\Bundle\BlogBundle\Form\Type\CategoryCreateFormType;
use SmartCore\Bundle\BlogBundle\Form\Type\CategoryFormType;
use SmartCore\Bundle\BlogBundle\Pagerfanta\SimpleDoctrineORMAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * Маршрут просмотра списка категорий.
     *
     * @var string
     */
    protected $routeCategory;

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
        $this->bundleName             = 'SmartBlogBundle';

        $this->categoryServiceName    = 'smart_blog.category';
        $this->routeIndex             = 'smart_blog.category.articles';
        $this->routeAdminCategory     = 'smart_blog_admin_category';
        $this->routeAdminCategoryEdit = 'smart_blog_admin_category_edit';
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        /** @var \SmartCore\Bundle\BlogBundle\Service\CategoryService $categoryService */
        $categoryService = $this->get($this->categoryServiceName);
        $category = $categoryService->create();

        $form = $this->createForm(new CategoryCreateFormType(get_class($category)), $category);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $categoryService->update($category);

                return $this->redirect($this->generateUrl($this->routeAdminCategory));
            }
        }

        return $this->render($this->bundleName . ':Admin/Category:list.html.twig', [
            'categoryClass' => get_class($category),
            'form'          => $form->createView(),
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
        /** @var \SmartCore\Bundle\BlogBundle\Model\CategoryInterface $category */
        $category = $this->get($this->categoryServiceName)->get($id);

        if (null === $category) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new CategoryFormType(get_class($category)), $category);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                /** @var \SmartCore\Bundle\BlogBundle\Service\CategoryService $categoryService */
                $categoryService = $this->get($this->categoryServiceName);
                $categoryService->update($category);

                return $this->redirect($this->generateUrl($this->routeAdminCategory));
            }
        }

        return $this->render($this->bundleName . ':Admin/Category:edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
