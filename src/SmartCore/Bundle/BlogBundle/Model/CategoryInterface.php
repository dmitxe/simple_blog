<?php

namespace SmartCore\Bundle\BlogBundle\Model;

interface CategoryInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param CategoryInterface $parent
     * @return $this
     */
    public function setParent(CategoryInterface $parent);

    /**
     * @return CategoryInterface
     */
    public function getParent();

    /**
     * @return mixed
     */
    public function getSlug();

    /**
     * @param mixed $slug
     * @return $this
     */
    public function setSlug($slug);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title);
}
