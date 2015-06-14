<?php
namespace App;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Settings extends \Kdyby\Doctrine\Entities\BaseEntity
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
    protected $admin_login;

    /**
     * @ORM\Column(type="string")
     */
    protected $admin_pass;

    /**
     * @ORM\Column(type="string")
     */
    protected $admin_email;

}