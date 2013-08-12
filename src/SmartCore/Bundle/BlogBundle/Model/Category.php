<?php

namespace SmartCore\Bundle\BlogBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @UniqueEntity(fields={"slug", "parent"}, message="В каждой категории должен быть уникальный сегмент URI.")
 */
abstract class Category implements CategoryInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children", cascade={"persist"})
     * @ORM\JoinColumn(name="parent")
     *
     * @var Category
     **/
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     * ORM\OrderBy({"position" = "ASC"})
     */
    protected $children;

    /**
     * @ORM\Column(type="string", length=32, unique=true)
     */
    protected $slug;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\OneToMany(targetEntity="Article", mappedBy="category")
     */
    protected $articles;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->articles   = new ArrayCollection();
        $this->children   = new ArrayCollection();
        $this->created_at = new \DateTime();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * @return Category[]|ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return \Datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return Article[]
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param CategoryInterface $parent
     * @return $this
     */
    public function setParent(CategoryInterface $parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Получить полный путь, включая родительские категории.
     *
     * @return string
     */
    public function getSlugFull()
    {
        $slug = $this->getSlug();

        if ($this->getParent()) {
            $slug  = $this->getParent()->getSlugFull() . '/' . $slug;
        }

        return $slug;
    }
}
