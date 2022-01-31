<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmailTemplateRepository")
 */
class EmailTemplate
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="hash", type="string")
     */
    protected $hash;

    /**
     * @ORM\Column(name="name", type="string")
     */
    protected $name;

    /**
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(name="tags", type="string", nullable=true)
     */
    protected $tags;

    /**
     * @ORM\Column(name="subject", type="string", nullable=true)
     */
    protected $subject;

    /**
     * @ORM\Column(name="content_html", type="text", nullable=true)
     */
    protected $contentHtml;

    /**
     * @ORM\Column(name="content_text", type="text", nullable=true)
     */
    protected $contentText;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $hash
     * @return $this
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null $description
     * @return $this
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $subject
     * @return $this
     */
    public function setSubject($subject = null)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param $contentHtml
     * @return $this
     */
    public function setContentHtml($contentHtml = null)
    {
        $this->contentHtml = $contentHtml;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContentHtml()
    {
        return $this->contentHtml;
    }

    /**
     * @param null $contentText
     * @return $this
     */
    public function setContentText($contentText = null)
    {
        $this->contentText = $contentText;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContentText()
    {
        return $this->contentText;
    }

    /**
     * @param null $tags
     * @return $this
     */
    public function setTags($tags = null)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }
}
