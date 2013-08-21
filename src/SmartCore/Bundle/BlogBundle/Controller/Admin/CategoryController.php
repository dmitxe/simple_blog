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
        $this->categoryServiceName   = 'smart_blog.category';
        $this->routeIndex       = 'smart_blog_category_index';
        $this->routeAdminCategory    = 'smart_blog_admin_category';
        $this->routeAdminCategoryEdit= 'smart_blog_admin_category_edit';
        $this->bundleName       = 'SmartBlogBundle';
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

        $pagerfanta = new Pagerfanta(new SimpleDoctrineORMAdapter($categoryService->getFindAllQuery()));
        $pagerfanta->setMaxPerPage($categoryService->getItemsCountPerPage());

        try {
            $pagerfanta->setCurrentPage($request->query->get('page', 1));
        } catch (NotValidCurrentPageException $e) {
            return $this->redirect($this->generateUrl($this->routeAdminCategory));
        }

        return $this->render($this->bundleName . ':Admin/Category:list.html.twig', [
            'form'       => $form->createView(),
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
        /** @var \SmartCore\Bundle\BlogBundle\Model\CategoryInterface $category */
        $category = $this->get($this->categoryServiceName)->get($id);

        if (null === $category) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new CategoryFormType(get_class($category)), $category);
        if ($request->isMethod('POST')) {
            $form->submit($request);

            if ($form->isValid()) {
                /** @var \Doctrine\ORM\EntityManager $em */
                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $em->flush();

                return $this->redirect($this->generateUrl($this->routeAdminCategory));
            }
        }

        return $this->render($this->bundleName . ':Admin/Category:edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
