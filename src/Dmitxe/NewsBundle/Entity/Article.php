<?php

namespace Dmitxe\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SmartCore\Bundle\BlogBundle\Model\Article as SmartArticle;
use SmartCore\Bundle\BlogBundle\Model\TaggableInterface;

/**
* @ORM\Entity(repositoryClass="SmartCore\Bundle\BlogBundle\Repository\ArticleRepository")
* @ORM\Table(name="news",
*       indexes={
*           @ORM\Index(name="created_at", columns={"created_at"})
*       }
* )
*/
class Article extends SmartArticle implements TaggableInterface
{
    use TagTrait;
}
