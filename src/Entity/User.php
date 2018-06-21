<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface , \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", options={"comment":"User ID"} )
     */
    private $user_id;

    /**
     * @ORM\Column(type="string", length=190, nullable=false, unique=true, options={"comment":"Email address"} )
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $user_mail;

    /**
     * @ORM\Column(type="string", length=200, nullable=false, options={"comment":"User password"} )
     */
    private $user_pass;

    /**
     * @ORM\Column(type="datetime", length=100, nullable=false, options={"comment":"Registration date"} )
     */
    private $user_registered;

    /**
     * @ORM\Column(type="string", length=100, nullable=false, options={"comment":"Root rank"} )
     */
    private $user_group;

    public function __toString()
    {
        return $this->getUserMail();
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimestamp()
    {
        if ($this->user_registered == null)
        {
            $this->user_registered = new \DateTime();
        }
    }

    public function serialize()
    {
        return serialize(array(
            $this->user_id,
            $this->getUsername(),
            $this->getPassword()
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $newId,
            $newUname,
            $newPass
            ) = unserialize($serialized);

        $this->user_id=$newId;
        $this->user_mail=$newUname;
        $this->user_pass=$newPass;
    }

    public function getRoles()
    {
        //return ['ROLE_A', 'ROLE_B', 'ROLE_TBD1', 'ROLE_TBD2', 'ROLE_ROOT'];
        return array("ROLE_".$this->getUserGroup());
    }

    public function getPassword()
    {
        return $this->getUserPass();
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->getUserMail();
    }

    public function eraseCredentials()
    {
        $this->setUserPass("");
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getUserMail(): string
    {
        return $this->user_mail;
    }

    public function setUserMail(string $user_mail): self
    {
        $this->user_mail = $user_mail;

        return $this;
    }

//    /**
//     * Set userEmail
//     *
//     * @param string $userEmail
//     *
//     * @return User
//     */
//    public function setUserMail($userEmail)
//    {
//        $this->user_mail = $userEmail;
//
//        return $this;
//    }
//
//    /**
//     * Get userEmail
//     *
//     * @return string
//     */
//    public function getUserMail()
//    {
//        return $this->user_mail;
//    }

    public function getUserPass(): string
    {
        return $this->user_pass;
    }

    public function setUserPass(string $user_pass): self
    {
        $this->user_pass = $user_pass;

        return $this;
    }

    public function getUserRegistered(): \DateTime
    {
        return $this->user_registered;
    }

    public function setUserRegistered(\DateTime $user_registered): self
    {
        $this->user_registered = $user_registered;

        return $this;
    }

    public function getUserGroup(): string
    {
        return $this->user_group;
    }

    public function setUserGroup(string $user_group): self
    {
        $this->user_group = $user_group;

        return $this;
    }
}
