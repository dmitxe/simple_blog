<?php
namespace SmartCore\Bundle\BlogBundle\Form\Factory;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class FormFactory
{
    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var string
     */
    protected $type;

    /**
     * Constructor.
     *
     * @param FormFactoryInterface $formFactory
     * @param string               $type
     */
    public function __construct(FormFactoryInterface $formFactory, $type)
    {
        $this->formFactory = $formFactory;
        $this->type        = $type;
    }

    /**
     * @return FormInterface
     */
    public function createForm($data = null)
    {
        return $this->formFactory->create($this->type, $data);
    }
}
