<?php

namespace SmartCore\Bundle\BlogBundle\Service;

use Doctrine\Common\Cache\Cache;
use Doctrine\ORM\EntityManager;
use Pagerfanta\Pagerfanta;
use SmartCore\Bundle\BlogBundle\Event\FilterArticleEvent;
use SmartCore\Bundle\BlogBundle\Model\ArticleInterface;
use SmartCore\Bundle\BlogBundle\Model\CategoryInterface;
use SmartCore\Bundle\BlogBundle\Pagerfanta\SimpleDoctrineORMAdapter;
use SmartCore\Bundle\BlogBundle\Repository\ArticleRepositoryInterface;
use SmartCore\Bundle\BlogBundle\SmartBlogEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ArticleService extends AbstractBlogService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var \SmartCore\Bundle\BlogBundle\SmartBlogEvents
     *
     * @todo эксперименты с событиями.
     */
    protected $eventClass;

    /**
     * Constructor.
     *
     * @param \SmartCore\Bundle\BlogBundle\Repository\ArticleRepository $articlesRepo
     * @param int $itemsPerPage
     */
    public function __construct(
        EntityManager $em,
        ArticleRepositoryInterface $articlesRepo,
        Cache $cache,
        EventDispatcherInterface $eventDispatcher,
        $itemsPerPage = 10
    ) {
        $this->articlesRepo     = $articlesRepo;
        $this->cache            = $cache;
        $this->em               = $em;
        $this->eventDispatcher  = $eventDispatcher;
        $this->eventClass       = 'SmartCore\Bundle\BlogBundle\SmartBlogEvents'; // @todo эксперименты с событиями.

        $this->setItemsCountPerPage($itemsPerPage);
    }

    /**
     * @return ArticleInterface
     */
    public function create()
    {
        $class = $this->articlesRepo->getClassName();

        $article = new $class();

        // @todo эксперименты с событиями.
        $event = new FilterArticleEvent($article);
        $class = $this->eventClass;
        $this->eventDispatcher->dispatch($class::ARTICLE_CREATE, $event);

        return $article;
    }

    /**
     * @param ArticleInterface $article
     */
    public function update(ArticleInterface $article, $setUpdatedAt = true)
    {
        $event = new FilterArticleEvent($article);
        $this->eventDispatcher->dispatch(SmartBlogEvents::ARTICLE_PRE_UPDATE, $event);

        if ($setUpdatedAt) {
            $article->setUpdated();
        }

        $this->em->persist($article);
        $this->em->flush($article);

        $event = new FilterArticleEvent($article);
        $this->eventDispatcher->dispatch(SmartBlogEvents::ARTICLE_POST_UPDATE, $event);
    }

    /**
     * @param ArticleInterface $article
     */
    public function delete(ArticleInterface $article)
    {
        $event = new FilterArticleEvent($article);
        $this->eventDispatcher->dispatch(SmartBlogEvents::ARTICLE_PRE_DELETE, $event);

        $this->em->remove($article);
        $this->em->flush($article);

        $event = new FilterArticleEvent($article);
        $this->eventDispatcher->dispatch(SmartBlogEvents::ARTICLE_POST_DELETE, $event);
    }

    /**
     * @param int $id
     * @return ArticleInterface|null
     */
    public function get($id)
    {
        return $this->articlesRepo->find($id);
    }

    /**
     * @return Cache
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param CategoryInterface $category
     * @param int|null $limit
     * @param int|null $offset
     * @return ArticleInterface[]|null
     *
     * @todo доделать или удалить.
     */
    public function getByCategory(CategoryInterface $category = null, $limit = null, $offset = null)
    {
        return $this->articlesRepo->findByCategory($category, $limit, $offset);
    }

    /**
     * @param CategoryInterface[]|array $categories
     * @param int|null $limit
     * @param int|null $offset
     * @return ArticleInterface[]|null
     */
    public function getByCategories(array $categories = [], $limit = null, $offset = null)
    {
        return $this->articlesRepo->findByCategories($categories, $limit, $offset);
    }

    /**
     * @param CategoryInterface|null $category
     * @return \Doctrine\ORM\Query
     */
    public function getFindByCategoryQuery(CategoryInterface $category = null)
    {
        return $this->articlesRepo->getFindByCategoryQuery($category);
    }

    /**
     * @param array $categories
     * @return \Doctrine\ORM\Query
     */
    public function getFindByCategoriesQuery(array $categories = [], $limit = null, $offset = null)
    {
        return $this->articlesRepo->getFindByCategoriesQuery($categories, $limit, $offset);
    }

    /**
     * @param \DateTime|null $firstDate
     * @param \DateTime|null $lastDate
     * @return \Doctrine\ORM\Query
     */
    public function getFindByDateQuery(\DateTime $firstDate = null, \DateTime $lastDate = null)
    {
        return $this->articlesRepo->getFindByDateQuery($firstDate, $lastDate);
    }

    /**
     * @param string $slug
     * @return ArticleInterface|null
     */
    public function getBySlug($slug)
    {
        return $this->articlesRepo->findOneBy(['slug' => $slug]);
    }

    /**
     * @param CategoryInterface $category
     * @return int
     */
    public function getCountByCategory(CategoryInterface $category = null)
    {
        return $this->articlesRepo->getCountByCategory($category);
    }

    /**
     * @param int|null $limit
     * @return ArticleInterface[]|null
     */
    public function getLast($limit = 10)
    {
        if (!$limit) {
            $limit = $this->getItemsCountPerPage();
        }

        return $this->articlesRepo->findLast($limit);
    }

    /**
     * @param int $limit
     * @return array
     */
    public function getArchiveMonthly($limit = 24)
    {
        return $this->articlesRepo->getArchiveMonthly($limit);
    }
}
