<?php

namespace Dmitxe\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SmartCore\Bundle\BlogBundle\Model\Tag as SmartTag;

/**
 * @ORM\Entity(repositoryClass="SmartCore\Bundle\BlogBundle\Repository\TagRepository")
 * @ORM\Table(name="blog_tags",
 *      indexes={
 *          @ORM\Index(name="weight", columns={"weight"})
 *      }
 * )
 */
class Tag extends SmartTag
{

}
