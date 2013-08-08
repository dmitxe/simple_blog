<?php

namespace SmartCore\Bundle\BlogBundle\Service;

use Doctrine\ORM\EntityRepository;
use SmartCore\Bundle\BlogBundle\Model\TagInterface;
use SmartCore\Bundle\BlogBundle\Repository\ArticleRepositoryInterface;

class TagService extends AbstractBlogService
{
    /**
     * @var \SmartCore\Bundle\BlogBundle\Repository\TagRepository
     */
    protected $tagsRepo;

    /**
     * @param \SmartCore\Bundle\BlogBundle\Repository\ArticleRepository $articlesRepo
     * @param \SmartCore\Bundle\BlogBundle\Repository\TagRepository $tagsRepo
     * @param int $itemsPerPage
     */
    public function __construct(ArticleRepositoryInterface $articlesRepo, EntityRepository $tagsRepo, $itemsPerPage = 10)
    {
        $this->articlesRepo = $articlesRepo;
        $this->tagsRepo     = $tagsRepo;
        $this->setItemsCountPerPage($itemsPerPage);
    }

    /**
     * @param TagInterface $tag
     * @return \Doctrine\ORM\Query
     */
    public function getFindByTagQuery(TagInterface $tag)
    {
        return $this->articlesRepo->getFindByTagQuery($tag);
    }

    /**
     * @param TagInterface $tag
     * @return int
     *
     * @todo возможность выбора по нескольким тэгам.
     */
    public function getArticlesCountByTag(TagInterface $tag = null)
    {
        return $this->tagsRepo->getCountByTag($tag);
    }

    /**
     * @param string $slug
     * @return TagInterface
     * @throws \Exception
     *
     * @todo нормальный выброс исключения.
     */
    public function getBySlug($slug)
    {
        if (null === $this->tagsRepo) {
            throw new \Exception('Необходимо сконфигурировать тэги.');
        }

        return $this->tagsRepo->findOneBy(['slug' => $slug]);
    }

    /**
     * @return @return Tag[]|null
     * @throws \Exception
     *
     * @todo нормальный выброс исключения.
     */
    public function getCloud()
    {
        if (null === $this->tagsRepo) {
            throw new \Exception('Необходимо сконфигурировать тэги.');
        }

        return $this->tagsRepo->findAll();
    }
}
