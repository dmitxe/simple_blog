<?php

namespace SmartCore\Bundle\BlogBundle\Controller\Admin;

use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\Pagerfanta;
use SmartCore\Bundle\BlogBundle\Pagerfanta\SimpleDoctrineORMAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use SmartCore\Bundle\BlogBundle\Form\Type\TagFormType;
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
        $this->routeAdminTag    = 'smart_blog_admin_tag';
        $this->routeAdminTagEdit= 'smart_blog_admin_tag_edit';
        $this->bundleName       = 'SmartBlogBundle';
    }

    /**
     * @return Response
     */
    public function indexAction(Request $request)
    {
        /** @var \SmartCore\Bundle\BlogBundle\Service\TagService $tagService */
        $tagService = $this->get($this->tagServiceName);
        $tag = $tagService->create();

        $form = $this->createForm(new TagFormType(get_class($tag)), $tag);
        if ($request->isMethod('POST')) {
            $form->submit($request);

            if ($form->isValid()) {
                ld($tag);
                $tag = $form->getData();
                /** @var \Doctrine\ORM\EntityManager $em */
                $em = $this->getDoctrine()->getManager();
                $em->persist($tag);
                $em->flush();
                return $this->redirect($this->generateUrl($this->routeAdminTag));
            }
            else ld($form->getErrors());
        }

        $pagerfanta = new Pagerfanta(new SimpleDoctrineORMAdapter($tagService->getFindAllQuery()));
        $pagerfanta->setMaxPerPage($tagService->getItemsCountPerPage());

        try {
            $pagerfanta->setCurrentPage($request->query->get('page', 1));
        } catch (NotValidCurrentPageException $e) {
            return $this->redirect($this->generateUrl($this->routeAdminTag));
        }

        return $this->render($this->bundleName . ':Admin/Tag:list.html.twig', [
            'tags' => $tagService->getCloud($this->routeAdminTag),
            'form' => $form->createView(),
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
        /** @var \SmartCore\Bundle\BlogBundle\Model\TagInterface $tag */
        $tag = $this->get($this->tagServiceName)->get($id);

        if (null === $tag) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new TagFormType(get_class($tag)), $tag);
        if ($request->isMethod('POST')) {
            $form->submit($request);

            if ($form->isValid()) {
                $tag = $form->getData();

                /** @var \Doctrine\ORM\EntityManager $em */
                $em = $this->getDoctrine()->getManager();
                $em->persist($tag);
                $em->flush();

                return $this->redirect($this->generateUrl($this->routeAdminTag));
            }
        }

        return $this->render($this->bundleName . ':Admin/Tag:edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createAction(Request $request)
    {
        /** @var \SmartCore\Bundle\BlogBundle\Model\TagInterface $tag */
        $tag = $this->get($this->tagServiceName)->create();

        $form = $this->createForm(new TagFormType(get_class($tag)), $tag);
        if ($request->isMethod('POST')) {
            $form->submit($request);

            if ($form->isValid()) {
                $tag = $form->getData();

                /** @var \Doctrine\ORM\EntityManager $em */
                $em = $this->getDoctrine()->getManager();
                $em->persist($tag);
                $em->flush();

                return $this->redirect($this->generateUrl($this->routeAdminTag));
            }
        }

        return $this->render($this->bundleName . ':Admin/Tag:create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
