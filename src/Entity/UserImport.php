<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

// alternative: voter, rbac
// order: UserImport, security.yml, login.html.twig, SecurityController, base.html.twig, CarController

/*
php bin/console doctrine:generate:entities AppBundle/Entity/UserImport

php bin/console doctrine:database:drop --force -q
php bin/console doctrine:database:create -q
php bin/console doctrine:schema:update --force -q
php bin/console doctrine:fixtures:load --no-interaction -q
*/
/*
    composer require --dev phpunit/phpunit
    edit DefaultController - no DIE
    edit DataLoader - no echo
    phpunit --tap
*/


/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks()
 */
class UserImport implements UserInterface , \Serializable
{
    /**
     * @ORM\Column(type="integer", options={"comment":"UserImport ID"} )
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $user_id;

    /**
     * @ORM\Column(type="string", length=190, nullable=false, unique=true, options={"comment":"Email address"} )
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $user_email;

    /**
     * @ORM\Column(type="string", length=200, nullable=false, options={"comment":"UserImport password"} )
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
        return $this->getUserEmail();
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
        $this->user_email=$newUname;
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
        return $this->getUserEmail();
    }

    public function eraseCredentials()
    {
        $this->setUserPass("");
    }

    // AUTO //

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set userEmail
     *
     * @param string $userEmail
     *
     * @return UserImport
     */
    public function setUserEmail($userEmail)
    {
        $this->user_email = $userEmail;

        return $this;
    }

    /**
     * Get userEmail
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->user_email;
    }

    /**
     * Set userPass
     *
     * @param string $userPass
     *
     * @return UserImport
     */
    public function setUserPass($userPass)
    {
        $this->user_pass = $userPass;

        return $this;
    }

    /**
     * Get userPass
     *
     * @return string
     */
    public function getUserPass()
    {
        return $this->user_pass;
    }

    /**
     * Set userRegistered
     *
     * @param \DateTime $userRegistered
     *
     * @return UserImport
     */
    public function setUserRegistered($userRegistered)
    {
        $this->user_registered = $userRegistered;

        return $this;
    }

    /**
     * Get userRegistered
     *
     * @return \DateTime
     */
    public function getUserRegistered()
    {
        return $this->user_registered;
    }

    /**
     * Set userGroup
     *
     * @param string $userGroup
     *
     * @return UserImport
     */
    public function setUserGroup($userGroup)
    {
        $this->user_group = $userGroup;

        return $this;
    }

    /**
     * Get userGroup
     *
     * @return string
     */
    public function getUserGroup()
    {
        return $this->user_group;
    }
}
