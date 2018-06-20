<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $user_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user_mail;

    /**
     * @ORM\Column(type="string", length=200)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $user_pass;

    /**
     * @ORM\Column(type="datetime")
     */
    private $user_registered;

    /**
     * @ORM\Column(type="string", length=100)
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

    public function getUserPass(): string
    {
        return $this->user_pass;
    }

    public function setUserPass(string $user_pass): self
    {
        $this->user_pass = $user_pass;

        return $this;
    }

    public function getUserRegistered(): \DateTimeInterface
    {
        return $this->user_registered;
    }

    public function setUserRegistered(\DateTimeInterface $user_registered): self
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
