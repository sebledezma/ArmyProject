<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
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

    public function getId()
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getUserMail(): ?string
    {
        return $this->user_mail;
    }

    public function setUserMail(string $user_mail): self
    {
        $this->user_mail = $user_mail;

        return $this;
    }

    public function getUserPass(): ?string
    {
        return $this->user_pass;
    }

    public function setUserPass(string $user_pass): self
    {
        $this->user_pass = $user_pass;

        return $this;
    }

    public function getUserRegistered(): ?\DateTimeInterface
    {
        return $this->user_registered;
    }

    public function setUserRegistered(\DateTimeInterface $user_registered): self
    {
        $this->user_registered = $user_registered;

        return $this;
    }

    public function getUserGroup(): ?string
    {
        return $this->user_group;
    }

    public function setUserGroup(string $user_group): self
    {
        $this->user_group = $user_group;

        return $this;
    }
}
