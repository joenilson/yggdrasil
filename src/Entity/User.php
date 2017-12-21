<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="users_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=25, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=120, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=25, nullable=false)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=140, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=1, nullable=false)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetime", nullable=false)
     */
    private $datecreation;

    /**
     * @var string
     *
     * @ORM\Column(name="usercreation", type="string", length=25, nullable=false)
     */
    private $usercreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datemodified", type="datetime", nullable=true)
     */
    private $datemodified;

    /**
     * @var string
     *
     * @ORM\Column(name="usermodify", type="string", length=25, nullable=true)
     */
    private $usermodify;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=120, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=5, nullable=false)
     */
    private $locale;

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getDatecreation()
    {
        return $this->datecreation;
    }

    public function getUsercreation()
    {
        return $this->usercreation;
    }

    public function getDatemodified()
    {
        return $this->datemodified;
    }

    public function getUsermodify()
    {
        return $this->usermodify;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function setDatecreation(\DateTime $datecreation)
    {
        $this->datecreation = $datecreation;
        return $this;
    }

    public function setUsercreation($usercreation)
    {
        $this->usercreation = $usercreation;
        return $this;
    }

    public function setDatemodified(\DateTime $datemodified)
    {
        $this->datemodified = $datemodified;
        return $this;
    }

    public function setUsermodify($usermodify)
    {
        $this->usermodify = $usermodify;
        return $this;
    }

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }


}

