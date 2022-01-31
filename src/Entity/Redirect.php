<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RedirectRepository")
 */
class Redirect
{
    use TimestampableEntity;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="from_link", type="string", nullable=true)
     */
    protected $fromLink;

    /**
     * @ORM\Column(name="to_link", type="string", nullable=true)
     */
    protected $toLink;

    /**
     * @ORM\Column(name="is_active", type="string", nullable=true)
     */
    protected $isActive;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $fromLink
     * @return Redirect
     */
    public function setFromLink($fromLink = null): Redirect
    {
        $this->fromLink = $fromLink;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFromLink()
    {
        return $this->fromLink;
    }

    /**
     * @param null $toLink
     * @return Redirect
     */
    public function setToLink($toLink = null): Redirect
    {
        $this->toLink = $toLink;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getToLink()
    {
        return $this->toLink;
    }

    /**
     * @param null $isActive
     * @return Redirect
     */
    public function setIsActive($isActive = null): Redirect
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
}
