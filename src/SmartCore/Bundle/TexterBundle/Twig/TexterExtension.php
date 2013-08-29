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
            'texter' => new \Twig_Function_Method(
                $this,
                'texterFunction',
                ['is_safe' => ['html']
            ]),
        ];
    }

    /**
     * @param string $name
     * @return string
     */
    public function texterFunction($name)
    {
        $text = $this->em->getRepository('SmartTexterBundle:Text')->findOneBy(['name' => $name]);

        if ($text) {
            return $text->getText();
        } else {
            return "Текст с id '$name' не найден.";
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'texter_extension';
    }
}
