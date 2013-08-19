<?php

namespace SmartCore\Bundle\TexterBundle;

//use SmartCore\Bundle\EngineBundle\Module\Bundle;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use SmartCore\Bundle\TexterBundle\Entity\Item;

class SmartTexterBundle extends Bundle
{
    /**
     * Действие при создании ноды.
     */
    public function createNode($node)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');

        $item = new Item();
        $item->setUserId($this->container->get('security.context')->getToken()->getUser()->getId());

        $em->persist($item);
        $em->flush();

        $node->setParams([
            'text_item_id' => $item->getId()
        ]);
    }

    public function hasAdmin()
    {
        return true;
    }
}
