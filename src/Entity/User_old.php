<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

class User_old implements UserInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $fullname;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $role;

    /**
     * @var bool
     */
    private $isActive;

    /**
     * @var string
     */
    private $lastIp;

    /**
     * @var \DateTime
     */
    private $lastTime;

    /**
     * @var string
     */
    private $sessionToken;

    /**
     * @var \DateTime
     */
    private $dateCreation;

    /**
     * @var string
     */
    private $userCreation;

    /**
     * @var \DateTime
     */
    private $dateModify;

    /**
     * @var string
     */
    private $userModify;

    public function getRoles()
    {
        return array($this->getRole());
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseUserCredentials()
    {

    }

    public function eraseCredentials()
    {

    }

    public function getOldpassword()
    {

    }

    public function setOldpassword()
    {

    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set fullname
     *
     * @param string $fullname
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get fullname
     *
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set locale
     *
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set role
     *
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Users
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set lastIp
     *
     * @param string $lastIp
     *
     * @return Users
     */
    public function setLastIp($lastIp)
    {
        $this->lastIp = $lastIp;

        return $this;
    }

    /**
     * Get lastIp
     *
     * @return string
     */
    public function getLastIp()
    {
        return $this->lastIp;
    }

    /**
     * Set lastTime
     *
     * @param \DateTime $lastTime
     *
     * @return Users
     */
    public function setLastTime($lastTime)
    {
        $this->lastTime = $lastTime;

        return $this;
    }

    /**
     * Get lastTime
     *
     * @return \DateTime
     */
    public function getLastTime()
    {
        return $this->lastTime;
    }

    /**
     * Set sessionToken
     *
     * @param string $sessionToken
     *
     * @return Users
     */
    public function setSessionToken($sessionToken)
    {
        $this->sessionToken = $sessionToken;

        return $this;
    }

    /**
     * Get sessionToken
     *
     * @return string
     */
    public function getSessionToken()
    {
        return $this->sessionToken;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Users
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set userCreation
     *
     * @param string $userCreation
     *
     * @return Users
     */
    public function setUserCreation($userCreation)
    {
        $this->userCreation = $userCreation;

        return $this;
    }

    /**
     * Get userCreation
     *
     * @return string
     */
    public function getUserCreation()
    {
        return $this->userCreation;
    }

    /**
     * Set dateModify
     *
     * @param \DateTime $dateModify
     *
     * @return Users
     */
    public function setDateModify($dateModify)
    {
        $this->dateModify = $dateModify;

        return $this;
    }

    /**
     * Get dateModify
     *
     * @return \DateTime
     */
    public function getDateModify()
    {
        return $this->dateModify;
    }

    /**
     * Set userModify
     *
     * @param string $userModify
     *
     * @return Users
     */
    public function setUserModify($userModify)
    {
        $this->userModify = $userModify;

        return $this;
    }

    /**
     * Get userModify
     *
     * @return string
     */
    public function getUserModify()
    {
        return $this->userModify;
    }
}