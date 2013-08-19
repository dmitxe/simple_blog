<?php

namespace SmartCore\Bundle\TexterBundle\Controller;

use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\Pagerfanta;
use SmartCore\Bundle\TexterBundle\Entity\Text;
use SmartCore\Bundle\TexterBundle\Form\Type\TexterCreateFormType;
use SmartCore\Bundle\TexterBundle\Form\Type\TexterEditFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $texterService = $this->get('smart_texter');

        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter($texterService->getFindAllQuery()));
        $pagerfanta->setMaxPerPage($texterService->getItemsCountPerPage());

        try {
            $pagerfanta->setCurrentPage($request->query->get('page', 1));
        } catch (NotValidCurrentPageException $e) {
            return $this->redirect($this->generateUrl('smart_texter_admin_index'));
        }

        return $this->render('SmartTexterBundle:Admin:list.html.twig', [
            'pagerfanta' => $pagerfanta,
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createAction(Request $request)
    {
        $text = new Text();

        $form = $this->createForm(new TexterCreateFormType(), $text);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                /** @var \Doctrine\ORM\EntityManager $em */
                $em = $this->getDoctrine()->getManager();
                $em->persist($text);
                $em->flush();

                return $this->redirect($this->generateUrl('smart_texter_admin_index'));
            }
        }

        return $this->render('SmartTexterBundle:Admin:create.html.twig', [
            'form' => $form->createView(),
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
        $text = $this->get('smart_texter')->get($id);

        if (null === $text) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new TexterEditFormType(), $text);
        if ($request->isMethod('POST')) {
            $form->submit($request);

            if ($form->isValid()) {
                /** @var \Doctrine\ORM\EntityManager $em */
                $em = $this->getDoctrine()->getManager();
                $em->persist($text);
                $em->flush();

                return $this->redirect($this->generateUrl('smart_texter_admin_index'));
            }
        }

        return $this->render('SmartTexterBundle:Admin:edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
