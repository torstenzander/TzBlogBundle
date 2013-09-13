<?php

namespace Tz\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Tz\BlogBundle\Entity\Comment
 *
 * @ORM\Table(name="comments")
 * @ORM\Entity
 */
class Comment
{
    /**
     * @var bigint $id
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var text $text
     *
     * @ORM\Column(name="text", type="text", nullable=false)
     */
    private $text;

    /**
     * @var text $email
     *
     * @ORM\Column(name="email", type="text", nullable=true)
     */
    private $email;

    /**
     * @var text $website
     *
     * @ORM\Column(name="website", type="text", nullable=true)
     */
    private $website;

    /**
     * @var \DateTime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime $lastTouched
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="last_touched", type="datetime", nullable=true)
     */
    private $lastTouched;

    /**
     * @var BlogPost
     *
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;

    /**
     * @param \Tz\BlogBundle\Entity\text $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return \Tz\BlogBundle\Entity\text
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param \Tz\BlogBundle\Entity\text $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return \Tz\BlogBundle\Entity\text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param \Tz\BlogBundle\Entity\text $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return \Tz\BlogBundle\Entity\text
     */
    public function getWebsite()
    {
        return $this->website;
    }



    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $lastTouched
     */
    public function setLastTouched($lastTouched)
    {
        $this->lastTouched = $lastTouched;
    }

    /**
     * @return \DateTime
     */
    public function getLastTouched()
    {
        return $this->lastTouched;
    }

    /**
     * @param \Tz\BlogBundle\Entity\Post $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    /**
     * @return \Tz\BlogBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}