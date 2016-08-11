<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="category", type="string", length=255)
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Announcement", mappedBy="categories")
     */
    private $annoucements;

    public function __construct()
    {
        $this->annoucements = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getCategory();
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
     * Set category
     *
     * @param string $category
     * @return Category
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add annoucements
     *
     * @param \AppBundle\Entity\Announcement $annoucements
     * @return Category
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
}
