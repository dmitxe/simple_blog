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
        $text->setName(1);
        $text->setText('Мой первый текстер.');
        $manager->persist($text);

        $text = new Text();
        $text->setName('about');
        $text->setText('<p>На этом сайте собраны различная полезная информация по тематике сайтостроения.</p>
<p>Информация больше собрана для себя, впрочем, надеюсь, что она будет также полезна и другим программистам.</p>
<p>Если Вам нужно создать сайт под ключ - свяжитесь со мной через форму обратной связи.</p>
<p>Данный блог написан на фреймворке Symfony 2.</p>');
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
