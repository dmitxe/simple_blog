<?php

namespace Dmitxe\FixturesBundle\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SmartCore\Bundle\MediaBundle\Entity\Collection;
use SmartCore\Bundle\MediaBundle\Entity\File;
use SmartCore\Bundle\MediaBundle\Entity\Storage;
use Symfony\Component\DependencyInjection\ContainerAware;

class LoadMediaData extends ContainerAware implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $storageLocal = new Storage();
        $storageLocal
            ->setTitle('Локальное хранилище')
            ->setProvider('SmartCore\Provider\Local')
            ->setBaseUrl('{basePath}/storage_uploads')
        ;

        $storageRemote = new Storage();
        $storageRemote
            ->setTitle('Тестовое хранилище')
            ->setProvider('SmartCore\Provider\Remote')
            ->setBaseUrl('http://example.com')
        ;

        $collection = new Collection();
        $collection
            ->setTitle('Тестовая коллекция')
            ->setRelativePath('/test_collection')
            ->setDefaultStorage($storageLocal)
        ;

        $file = new File();
        $file
            ->setOriginalFilename('example.jpg')
            ->setType('image')
            ->setMimeType('image/jpeg')
            ->setRelativePath('/2013/10')
            ->setSize(123)
            ->setCollection($collection);
        $manager->persist($file);

        $file = new File();
        $file
            ->setOriginalFilename('google.jpg')
            ->setType('image')
            ->setMimeType('image/jpeg')
            ->setRelativePath('/' . md5(microtime()))
            ->setSize(456)
            ->setStorage($storageRemote)
            ->setCollection($collection);
        $manager->persist($file);

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 10;
    }
}
