<?php

namespace SmartCore\Bundle\BlogBundle\Service;

use Doctrine\ORM\EntityRepository;
use SmartCore\Bundle\BlogBundle\Model\TagInterface;
use SmartCore\Bundle\BlogBundle\Repository\ArticleRepositoryInterface;
use Symfony\Component\Routing\RouterInterface;
use Zend\Tag\Cloud;

class TagService extends AbstractBlogService
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var \SmartCore\Bundle\BlogBundle\Repository\TagRepository
     */
    protected $tagsRepo;

    /**
     * @param \SmartCore\Bundle\BlogBundle\Repository\ArticleRepository $articlesRepo
     * @param \SmartCore\Bundle\BlogBundle\Repository\TagRepository $tagsRepo
     * @param int $itemsPerPage
     */
    public function __construct(ArticleRepositoryInterface $articlesRepo, EntityRepository $tagsRepo, RouterInterface $router, $itemsPerPage = 10)
    {
        $this->articlesRepo = $articlesRepo;
        $this->router       = $router;
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
     * @return TagInterface[]|null
     * @throws \Exception
     *
     * @todo нормальный выброс исключения.
     */
    public function getAll()
    {
        if (null === $this->tagsRepo) {
            throw new \Exception('Необходимо сконфигурировать тэги.');
        }

        return $this->tagsRepo->findAll();
    }


    /**
     * @param $route
     * @return array
     *
     * @todo сделать в сущности тэга weight, который будет автоматически инкрементироваться и декрементироваться при измнениях в статьях.
     */
    public function getCloud($route)
    {
        $cloud = [];
        $tags = $this->getAll();

        foreach ($tags as $tag) {
            $cloud[] = [
                'tag'    => $tag,
                'title'  => $tag->getTitle(),
                'weight' => $this->getArticlesCountByTag($tag),
                'params' => [
                    'url' => $this->router->generate($route, ['slug' => $tag->getSlug()])
                ],
            ];
        }

        return $cloud;
    }

    /**
     * @param $route
     * @return Cloud
     */
    public function getCloudZend($route)
    {
        return new Cloud([
            'tags' => $this->getCloud($route),
            'cloudDecorator' => [
                'decorator' => 'HtmlCloud',
                'options' => [
                    'htmlTags' => [
                        'div' => ['id' => 'tags']
                    ],
                    'separator' => ' ',
                ]
            ],
            'tagDecorator' => [
                'decorator' => 'HtmlTag',
                'options' => [
                    'htmlTags' => ['span'],
                ],
            ]
        ]);
    }
}
