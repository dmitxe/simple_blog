<?php

namespace SmartCore\Bundle\TexterBundle\Model;

interface TexterInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return mixed
     */
    public function getText();

    /**
     * @param string $text
     * @return $this
     */
    public function setText($text);
}

