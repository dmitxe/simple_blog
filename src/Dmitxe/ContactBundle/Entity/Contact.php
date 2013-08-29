<?php

namespace Dmitxe\ContactBundle\Entity;

use Mremi\ContactBundle\Entity\Contact as BaseContact;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="feedbacks")
 */
class Contact extends BaseContact
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTitle(self::TITLE_MR);
    }
}
