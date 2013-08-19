<?php

namespace SmartCore\Bundle\TexterBundle\Controller;

use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\Pagerfanta;
use SmartCore\Bundle\TexterBundle\Form\Type\TexterFormType;
use SmartCore\Bundle\TexterBundle\Pagerfanta\SimpleDoctrineORMAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    /**
     * Имя бандла. Для перегрузки шаблонов.
     *
     * @var string
     */
    protected $bundleName;

    /**
     * Маршрут на список текстов.
     *
     * @var string
     */
    protected $routeIndex;

    /**
     * Маршрут просмотра списка страниц по тексту.
     *
     * @var string
     */
    protected $routeTexter;

    /**
     * Имя сервиса по работе с текстом.
     *
     * @var string
     */
    protected $texterServiceName;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->texterServiceName   = 'smart_texter.texter';
        $this->routeIndex       = 'smart_texter_index';
        $this->routeAdminTag    = 'smart_texter_admin';
        $this->routeAdminTagEdit= 'smart_texter_admin_edit';
        $this->bundleName       = 'SmartTexterBundle';
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        /** @var \SmartCore\Bundle\BlogBundle\Service\TexterService $texterService */
        $texterService = $this->get($this->texterServiceName);
        $texter = $texterService->create();

        $form = $this->createForm(new TexterCreateFormType(get_class($texter)), $texter);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $texterService->update($texter);

                return $this->redirect($this->generateUrl($this->routeAdminTag));
            }
        }

        $pagerfanta = new Pagerfanta(new SimpleDoctrineORMAdapter($texterService->getFindAllQuery()));
        $pagerfanta->setMaxPerPage($texterService->getItemsCountPerPage());

        try {
            $pagerfanta->setCurrentPage($request->query->get('page', 1));
        } catch (NotValidCurrentPageException $e) {
            return $this->redirect($this->generateUrl($this->routeAdminTag));
        }

        return $this->render($this->bundleName . ':Admin:list.html.twig', [
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
        /** @var \SmartCore\Bundle\TexterBundle\Model\TexterInterface $texter */
        $texter = $this->get($this->texterServiceName)->get($id);

        if (null === $texter) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new TexterFormType(get_class($texter)), $texter);
        if ($request->isMethod('POST')) {
            $form->submit($request);

            if ($form->isValid()) {
                /** @var \Doctrine\ORM\EntityManager $em */
                $em = $this->getDoctrine()->getManager();
                $em->persist($texter);
                $em->flush();

                return $this->redirect($this->generateUrl($this->routeAdminTag));
            }
        }

        return $this->render($this->bundleName . ':Admin:edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
