<?php

namespace Dmitxe\SiteBundle\Menu;

use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher\Voter\VoterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RequestVoter implements VoterInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function matchItem(ItemInterface $item)
    {
        $request = $this->container->get('request');

        if ($item->getUri() === $request->getBaseUrl() . '/') {
            return false;
        }

        if ($item->getUri() === $request->getRequestUri()) {
            return true;
        } else {
            if ($item->getUri() !== '/' && (substr(
                        $request->getRequestUri(),
                        0,
                        strlen($item->getUri())
                    ) === $item->getUri())
            ) {
                return true;
            }
        }

        return null;
    }
}
