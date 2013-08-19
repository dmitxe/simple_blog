<?php

namespace SmartCore\Bundle\TexterBundle\Event;

use SmartCore\Bundle\TexterBundle\Model\TexterInterface;
use Symfony\Component\EventDispatcher\Event;

class FilterTexterEvent extends Event
{
    /**
     * @var TexterInterface
     */
    protected $texter;

    /**
     * Constructor.
     *
     * @param TexterInterface $texter
     */
    public function __construct(TexterInterface $texter)
    {
        $this->texter = $texter;
    }

    /**
     * @return TexterInterface
     */
    public function getTexter()
    {
        return $this->texter;
    }
}
