<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Announcement", mappedBy="user")
     */
    private $annoucements;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment", mappedBy="user")
     */
    private $comments;

    public function __construct()
    {
        parent::__construct();
        $this->annoucements = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     * Add annoucements
     *
     * @param \AppBundle\Entity\Announcement $annoucements
     * @return User
     */
    public function addAnnoucement(\AppBundle\Entity\Announcement $annoucements)
    {
        $this->annoucements[] = $annoucements;

        return $this;
    }

    /**
     * Remove annoucements
     *
     * @param \AppBundle\Entity\Announcement $annoucements
     */
    public function removeAnnoucement(\AppBundle\Entity\Announcement $annoucements)
    {
        $this->annoucements->removeElement($annoucements);
    }

    /**
     * Get annoucements
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAnnoucements()
    {
        return $this->annoucements;
    }

    /**
     * Add comments
     *
     * @param \AppBundle\Entity\Comment $comments
     * @return User
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
}
