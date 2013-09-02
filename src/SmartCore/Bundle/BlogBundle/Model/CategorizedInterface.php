<?php

namespace SmartCore\Bundle\BlogBundle\Model;

interface CategorizedInterface
{
    /**
     * @return CategoryInterface
     */
    public function getCategory();

    /**
     * @param CategoryInterface $category
     * @return $this
     */
    public function setCategory(CategoryInterface $category = null);
}
