<?php

namespace Dmitxe\BlogBundle\EventListener;

use SmartCore\Bundle\BlogBundle\Event\FilterArticleEvent;
use SmartCore\Bundle\BlogBundle\SmartBlogEvents;
use SmartCore\Bundle\MediaBundle\Service\CollectionService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ImageArticleListener implements EventSubscriberInterface
{
    /**
     * @var CollectionService
     */
    protected $mc;

    /**
     * Constructor.
     */
    public function __construct($mc)
    {
        $this->mc = $mc;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            SmartBlogEvents::ARTICLE_POST_UPDATE => 'uploadImage',
        ];
    }

    /**
     * @param FilterArticleEvent $event
     */
    public function uploadImage(FilterArticleEvent $event)
    {
        /** @var \Dmitxe\BlogBundle\Entity\Article $article */
        $article = $event->getArticle();

        $image = $article->getImage();

        if (null === $image) {
            return;
        }

        $this->mc->createFile($image);
    }
}
