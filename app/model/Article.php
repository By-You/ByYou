<?php

namespace App;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
*/
class Article extends \Kdyby\Doctrine\Entities\BaseEntity
{
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue
    */
    protected $id;

    /**
    * @ORM\Column(type="string")
    */
    protected $title;
}
