<?php

namespace SmartCore\Bundle\TexterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="SmartCore\Bundle\TexterBundle\Repository\TextRepository")
 * @ORM\Table(name="texter_items")
 */
class Text
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="text", nullable=TRUE)
     */
    protected $text;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    protected $createdAt;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getText();
    }

    /**
     * @return \Datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Получить анонс.
     *
     * @return string
     */
    public function getAnnounce()
    {
        $a = strip_tags($this->text);

        if (mb_strlen($a, 'utf-8') > 120) {
            $dotted = '...';
        } else {
            $dotted = '';
        }

        return mb_substr($a, 0, 120, 'utf-8') . $dotted;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }
}
