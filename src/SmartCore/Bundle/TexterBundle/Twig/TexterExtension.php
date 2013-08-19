<?php

namespace SmartCore\Bundle\TexterBundle\Twig;

use Doctrine\ORM\EntityManager;

class TexterExtension extends \Twig_Extension
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * Constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            'texter' => new \Twig_Function_Method($this, 'texterFunction'),
        ];
    }

    /**
     * @param integer $id
     * @return string
     */
    public function texterFunction($id)
    {
        return $this->em->find('SmartTexterBundle:Text', $id)->getText();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'texter_extension';
    }
}
