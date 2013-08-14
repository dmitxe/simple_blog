<?php

namespace SmartCore\Bundle\BlogBundle\Event;

use SmartCore\Bundle\BlogBundle\Model\ArticleInterface;
use Symfony\Component\EventDispatcher\Event;

class FilterArticleEvent extends Event
{
    /**
     * @var ArticleInterface
     */
    protected $article;

    /**
     * Constructor.
     *
     * @param ArticleInterface $article
     */
    public function __construct(ArticleInterface $article)
    {
        $this->article = $article;
    }

    /**
     * @return ArticleInterface
     */
    public function getArticle()
    {
        return $this->article;
    }
}
