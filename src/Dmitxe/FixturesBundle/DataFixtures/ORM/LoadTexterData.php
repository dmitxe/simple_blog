<?php

namespace Dmitxe\FixturesBundle\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SmartCore\Bundle\TexterBundle\Entity\Text;
use Symfony\Component\DependencyInjection\ContainerAware;

class LoadTexterData extends ContainerAware implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $text = new Text();
        $text->setText('Мой первый текстер.');
        $manager->persist($text);

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3;
    }
}
