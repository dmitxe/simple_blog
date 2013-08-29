<?php

namespace SmartCore\Bundle\TexterBundle\Twig;

use Doctrine\Common\Cache\Cache;
use Doctrine\ORM\EntityManager;

class TexterExtension extends \Twig_Extension
{
    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * Constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em, Cache $cache)
    {
        $this->cache = $cache;
        $this->em    = $em;
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
        $textFromCache = $this->cache->fetch($name);

        if (false != $textFromCache) {
            return $textFromCache;
        }

        $text = $this->em->getRepository('SmartTexterBundle:Text')->findOneBy(['name' => $name]);

        if ($text) {
            $this->cache->save($name, $text->getText(), 300);
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
