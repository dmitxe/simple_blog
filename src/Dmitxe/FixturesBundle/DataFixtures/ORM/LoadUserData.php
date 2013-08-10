<?php

namespace Dmitxe\FixturesBundle\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAware;
use Dmitxe\UserBundle\Entity\User;
use Dmitxe\UserBundle\Entity\Group;

class LoadUserData extends ContainerAware implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $encoder = $this->container->get('security.encoder_factory')->getEncoder(new User());

        $group_blogger = new Group('blogger', ['ROLE_BLOGGER']);
        $manager->persist($group_blogger);

        $group_admin = new Group('admin', ['ROLE_ADMIN']);
        $manager->persist($group_admin);

        $user = new User();
        $user->setUsername('root')
            ->setPassword($encoder->encodePassword('123', $user->getSalt()))
            ->setEmail('root@mail.ru')
            ->setEnabled(true) // @todo убрать на продакшине.
            ->addGroup($group_admin);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('digi')
            ->setPassword($encoder->encodePassword('123', $user->getSalt()))
            ->setEmail('digi@mail.ru')
            ->setEnabled(true) // @todo убрать на продакшине.
            ->addGroup($group_blogger);
        $manager->persist($user);

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
