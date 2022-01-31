<?php

namespace App\Entity;

use App\Core\Traits\Entity\UserCredentialTrait;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="fos_user")
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 */
class User implements UserInterface, \KevinPapst\AdminLTEBundle\Model\UserInterface, \Serializable
{
    use TimestampableEntity;
    use UserCredentialTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="firstname", type="string", nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(name="lastname", type="string", nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(name="registered_ip", type="string", nullable=true)
     */
    protected $registeredIp;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->id;
    }

    /**
     * @param null $firstname
     * @return $this
     */
    public function setFirstname($firstname = null)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param null $lastname
     * @return $this
     */
    public function setLastname($lastname = null)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    /**
     * @return string|void
     */
    public function getTitle()
    {
        // TODO: Implement getTitle() method.
    }

    /**
     * @return string|void
     */
    public function getAvatar()
    {
        // TODO: Implement getAvatar() method.
    }

    /**
     * @param null $registeredIp
     * @return $this
     */
    public function setRegisteredIp($registeredIp = null)
    {
        $this->registeredIp = $registeredIp;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRegisteredIp()
    {
        return $this->registeredIp;
    }

    /**
     * @return bool
     */
    public function isOnline()
    {
        return true;
    }

    /**
     * @return \DateTime
     */
    public function getMemberSince()
    {
        return $this->createdAt;
    }

    public function serialize(): string
    {
        return serialize([
            'id' => $this->id,
            'email' => $this->email,
            'username' => $this->username,
            'password' => $this->password,
            'salt' => $this->salt,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname
        ]);
    }

    public function unserialize($serialized)
    {
        $serialized = unserialize($serialized);

        $this->id = $serialized['id'];
        $this->email = $serialized['email'];
        $this->username = $serialized['username'];
        $this->password = $serialized['password'];
        $this->salt = $serialized['salt'];
        $this->firstname = $serialized['firstname'];
        $this->lastname = $serialized['lastname'];

        return $this;
    }
}
