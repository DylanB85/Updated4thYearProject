<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Category;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Member
 *
 * @ORM\Table(name="member")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MemberRepository")
 * @UniqueEntity(fields= "username") - These details match a current user!
 * @UniqueEntity(fields= "email") - These details match a current user!
 *
 *
 */
class Member implements UserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @var string
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     *
     */
    protected $username;

    /**
     *
     * @var string
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     *
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(name="categorys", type="string", length=255)
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Category", mappedBy="member")
     */
    protected $categorys;


    protected $plainPassword;


    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64)
     */
    protected $password;


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
     * @return Member
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
     * Set email
     *
     * @param string $email
     *
     * @return Member
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
     * Set password
     *
     * @param string $password
     *
     * @return Member
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
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }


    /**
     * Member constructor.
     */
    public function __construct()
    {
        $this->categorys = new ArrayCollection();
    }

    /**
     * @param string $categorys
     *
     * @return Member
     */

    public function setCategorys($categorys)
    {
        $this->categorys = $categorys;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategorys()
    {
        return $this->categorys;
    }


    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->categorys,
            $this->password,
        ]);
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->categorys,
            $this->password,
            ) = unserialize($serialized);
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
            return[
                'ROLE_' . strtoupper($this->categorys)
            ];
    }

}
