<?php

namespace SmartCore\Bundle\SimpleProfilerBundle\Twig;

use Doctrine\Common\Cache\Cache;
use Doctrine\ORM\EntityManager;

class ProfilerExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            'simple_profiler' => new \Twig_Function_Method(
                $this,
                'simpleProfiler',
                ['is_safe' => ['html']
            ]),
        ];
    }

    /**
     * @return string
     */
    public function simpleProfiler()
    {
        \Profiler::render();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'simple_profiler_extension';
    }
}
