<?php

namespace Dmitxe\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SmartCore\Bundle\BlogBundle\Model\Article as SmartNews;

/**
 * @ORM\Entity(repositoryClass="SmartCore\Bundle\BlogBundle\Repository\ArticleRepository")
 * @ORM\Table(name="news",
 *      indexes={
 *          @ORM\Index(name="created_at", columns={"created_at"})
 *      }
 * )
 */
class News extends SmartNews
{

}