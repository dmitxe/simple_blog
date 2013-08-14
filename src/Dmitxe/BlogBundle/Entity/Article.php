<?php

namespace Dmitxe\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SmartCore\Bundle\BlogBundle\Model\Article as SmartArticle;
use SmartCore\Bundle\BlogBundle\Model\CategoryTrait;
use SmartCore\Bundle\BlogBundle\Model\SignedArticleInterface;
use SmartCore\Bundle\BlogBundle\Model\TagTrait;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="SmartCore\Bundle\BlogBundle\Repository\ArticleRepository")
 * @ORM\Table(name="blog_articles",
 *      indexes={
 *          @ORM\Index(name="created_at", columns={"created_at"})
 *      }
 * )
 */
class Article extends SmartArticle implements SignedArticleInterface
{
    use CategoryTrait;
    use TagTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Dmitxe\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="author_id")
     */
    protected $author;

    /**
     * @Assert\File(
     *     maxSize="1M",
     *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg"}
     * )
     * @Vich\UploadableField(mapping="blog_image", fileNameProperty="image_name")
     *
     * @var File $image
     */
    protected $image;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $image_name;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $is_commentable;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->is_commentable = true;
    }

    /**
     * @param UserInterface $author
     * @return $this
     */
    public function setAuthor(UserInterface $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param bool $is_commentable
     * @return $this
     */
    public function setIsCommentable($is_commentable)
    {
        $this->is_commentable = $is_commentable;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsCommentable()
    {
        return $this->is_commentable;
    }
}
