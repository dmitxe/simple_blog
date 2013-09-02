<?php

namespace Dmitxe\NewsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use SmartCore\Bundle\BlogBundle\Model\Article as SmartArticle;
use SmartCore\Bundle\BlogBundle\Model\TaggableInterface;
use SmartCore\Bundle\BlogBundle\Model\TagInterface;

/**
 * В переопределяемом классе нельзя использовать трейт модели...
 * т.к. надо переопределять JoinTablе name="blog_articles_tags_relations".
 * по этому здесь используется TaggableInterface
 *
 * @ORM\Entity(repositoryClass="SmartCore\Bundle\BlogBundle\Repository\ArticleRepository")
 * @ORM\Table(name="news",
 *      indexes={
 *          @ORM\Index(name="created_at", columns={"created_at"})
 *      }
 * )
 */
class Article extends SmartArticle implements TaggableInterface
{
    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="articles", cascade={"persist"})
     * @ORM\JoinTable(name="news_articles_tags_relations",
     *      joinColumns={@ORM\JoinColumn(name="article_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id")}
     * )
     *
     * @var TagInterface[]|ArrayCollection|null
     */
    protected $tags;

    /**
     * @param Tag $tag
     * @return $this
     */
    public function addTag(TagInterface $tag)
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    /**
     * @param TagInterface $tag
     * @return $this
     */
    public function removeTag(TagInterface $tag)
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }

    /**
     * @param TagInterface[]|ArrayCollection $tags
     * @return $this
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return TagInterface[]|ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }
}
