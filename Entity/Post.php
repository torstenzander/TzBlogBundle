<?php

namespace Tz\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Tz\BlogBundle\Util\String;

/**
 * Post
 *
 * @ORM\Table(name="posts")
 * @ORM\Entity(repositoryClass="Tz\BlogBundle\Entity\PostRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Post
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     *
     * @var
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post",cascade={"persist"}, orphanRemoval=true)
     */
    private $comments;

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
     * @ORM\ManyToMany(targetEntity="Tz\BlogBundle\Entity\Tag", inversedBy="posts")
     */
    private $tags;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->title;
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

    /**
     * Set title
     *
     * @param string $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->setSlug(String::cleanForUrl($this->title));
        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Post
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * Set comments
     *
     * @param \Tz\BlogBundle\Entity\Comment $comments
     * @return Post
     */
    public function setComments(\Tz\BlogBundle\Entity\Comment $comments = null)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return \Tz\BlogBundle\Entity\Comment
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @return int
     */
    public function getNumberOfComments()
    {
        return $this->comments->count();
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Add comments
     *
     * @param \Tz\BlogBundle\Entity\comment $comments
     * @return Post
     */
    public function addComment(\Tz\BlogBundle\Entity\comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Tz\BlogBundle\Entity\comment $comments
     */
    public function removeComment(\Tz\BlogBundle\Entity\comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Add tags
     *
     * @param \Tz\BlogBundle\Entity\Tag $tags
     * @return Post
     */
    public function addTag(\Tz\BlogBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;
    
        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Tz\BlogBundle\Entity\Tag $tags
     */
    public function removeTag(\Tz\BlogBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }
}