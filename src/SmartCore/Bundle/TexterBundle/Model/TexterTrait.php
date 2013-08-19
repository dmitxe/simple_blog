<?php

namespace SmartCore\Bundle\TexterBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @todo разобраться с инкрементами, притом надо учесть, что если статья удаляется или деактивируется, тогда декрементить все счетчики тэгов.
 */
trait TexterTrait
{
    /**
     * @var TexterInterface[]|ArrayCollection|null
     */
    protected $texters;

    /**
     * @param Texter $texter
     * @return $this
     */
    public function addTexter(TexterInterface $texter)
    {
        if (!$this->tags->contains($texter)) {
            $this->tags->add($texter);
        }

        return $this;
    }

    /**
     * @param Texter $texter
     * @return $this
     */
    public function removeTexter(TexterInterface $texter)
    {
        if ($this->texters->contains($texter)) {
            $this->texters->removeElement($texter);
        }

        return $this;
    }

    /**
     * @param TexterInterface[]|ArrayCollection $texters
     * @return $this
     */
    public function setTexters($texters)
    {
        $this->texters = $texters;
        return $this;
    }

    /**
     * @return Texter[]|ArrayCollection
     */
    public function getTexters()
    {
        return $this->texters;
    }
}
