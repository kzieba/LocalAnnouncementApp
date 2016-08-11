<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Announcement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\AnnouncementRepository")
 */
class Announcement
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expirationTime", type="datetimetz")
     */
    private $expirationTime;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Photo")
     */
    private $photo;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Category", inversedBy="annoucements")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment", mappedBy="announcement")
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="annoucements")
     */
    private $user;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getTitle();
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
     * @return Announcement
     */
    public function setTitle($title)
    {
        $this->title = $title;

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
     * @return Announcement
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
     * Set expirationTime
     *
     * @param \DateTime $expirationTime
     * @return Announcement
     */
    public function setExpirationTime($expirationTime)
    {
        $this->expirationTime = $expirationTime;

        return $this;
    }

    /**
     * Get expirationTime
     *
     * @return \DateTime 
     */
    public function getExpirationTime()
    {
//        return gettype($this->expirationTime->getTimestamp());
//        return $this->expirationTime->getTimestamp();
        return $this->expirationTime;
//        return date('c', $this->expirationTime->getTimestamp());
    }

    /**
     * Set photo
     *
     * @param \AppBundle\Entity\Photo $photo
     * @return Announcement
     */
    public function setPhoto(\AppBundle\Entity\Photo $photo = null)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return \AppBundle\Entity\Photo 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Add categories
     *
     * @param \AppBundle\Entity\Category $categories
     * @return Announcement
     */
    public function addCategory(\AppBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \AppBundle\Entity\Category $categories
     */
    public function removeCategory(\AppBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add comments
     *
     * @param \AppBundle\Entity\Comment $comments
     * @return Announcement
     */
    public function addComment(\AppBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \AppBundle\Entity\Comment $comments
     */
    public function removeComment(\AppBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Announcement
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
