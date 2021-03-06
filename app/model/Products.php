<?php
namespace App;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Products extends \Kdyby\Doctrine\Entities\BaseEntity
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
    protected $nazev;

    /**
     * @ORM\Column(type="integer")
     */
    protected $cena;

    /**
     * @ORM\Column(type="integer")
     */
    protected $velikost;

}