<?php

namespace Dmitxe\ContactBundle\Controller;

use Dmitxe\ContactBundle\Form\Type\ContactType;
use Mremi\ContactBundle\ContactEvents;
use Mremi\ContactBundle\Event\ContactEvent;
use Mremi\ContactBundle\Event\FilterContactResponseEvent;
use Mremi\ContactBundle\Event\FormEvent;

use Mremi\ContactBundle\Controller\ContactController as BaseContactController;

use Mremi\ContactBundle\Provider\NoopSubjectProvider;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * В отличнии от оригинального контроллера, здесь только по другому создаётся форма. (стр. 35)
 */
class ContactController extends BaseContactController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response|RedirectResponse
     */
    public function indexAction(Request $request)
    {
        $dispatcher = $this->getEventDispatcher();
        $contact = $this->getContactManager()->create();

        $dispatcher->dispatch(ContactEvents::FORM_INITIALIZE, new ContactEvent($contact, $request));

        //$form = $this->getFormFactory()->createForm($contact);
        $form = $this->createForm(new ContactType(), $contact);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(ContactEvents::FORM_SUCCESS, $event);

                if (null === $response = $event->getResponse()) {
                    $response = new RedirectResponse($this->getRouter()->generate('mremi_contact_confirmation'));
                }

                $this->getContactManager()->save($contact, true);
                $this->getSession()->set('mremi_contact_data', $contact);

                $dispatcher->dispatch(ContactEvents::FORM_COMPLETED, new FilterContactResponseEvent($contact, $request, $response));

                return $response;
            }
        }

        return $this->render('MremiContactBundle:Contact:index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Confirm action in charge to render a confirmation message
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws AccessDeniedException If no contact stored in session
     */
    public function confirmAction(Request $request)
    {
        $contact = $this->getSession()->get('mremi_contact_data');

        if (!$contact) {
            throw new AccessDeniedException('Please fill the contact form');
        }

        return $this->render('MremiContactBundle:Contact:confirm.html.twig', [
            'contact' => $contact,
        ]);
    }

    /**
     * Gets the event dispatcher
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    private function getEventDispatcher()
    {
        return $this->get('event_dispatcher');
    }

    /**
     * Gets the form factory
     *
     * @return \Mremi\ContactBundle\Form\Factory\FormFactory
     */
    private function getFormFactory()
    {
        return $this->get('mremi_contact.form_factory');
    }

    /**
     * Gets the contact manager
     *
     * @return \Mremi\ContactBundle\Model\ContactManagerInterface
     */
    private function getContactManager()
    {
        return $this->get('mremi_contact.contact_manager');
    }

    /**
     * Gets the router
     *
     * @return \Symfony\Component\Routing\RouterInterface
     */
    private function getRouter()
    {
        return $this->get('router');
    }

    /**
     * Gets the session
     *
     * @return \Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    private function getSession()
    {
        return $this->get('session');
    }
}
