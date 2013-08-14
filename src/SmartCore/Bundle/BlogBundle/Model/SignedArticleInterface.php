<?php

namespace SmartCore\Bundle\BlogBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

interface SignedArticleInterface
{
    /**
     * @param UserInterface $user
     */
    public function setAuthor(UserInterface $user);

    /**
     * @return UserInterface
     */
    public function getAuthor();
}
