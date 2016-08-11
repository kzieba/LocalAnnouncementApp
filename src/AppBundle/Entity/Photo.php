<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Photo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PhotoRepository")
 */
class Photo
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
     * @ORM\Column(name="pathToFile", type="string", length=255)
     */
    private $pathToFile;

    /**
     * @var string
     *
     * @ORM\Column(name="altText", type="string", length=255)
     */
    private $altText;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Announcement", inversedBy="photos")
     */
    private $announcement;

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
     * Set pathToFile
     *
     * @param string $pathToFile
     * @return Photo
     */
    public function setPathToFile($pathToFile)
    {
        $this->pathToFile = $pathToFile;

        return $this;
    }

    /**
     * Get pathToFile
     *
     * @return string 
     */
    public function getPathToFile()
    {
        return $this->pathToFile;
    }

    /**
     * Set altText
     *
     * @param string $altText
     * @return Photo
     */
    public function setAltText($altText)
    {
        $this->altText = $altText;

        return $this;
    }

    /**
     * Get altText
     *
     * @return string 
     */
    public function getAltText()
    {
        return $this->altText;
    }

    /**
     * Set announcement
     *
     * @param \AppBundle\Entity\Announcement $announcement
     * @return Photo
     */
    public function setAnnouncement(\AppBundle\Entity\Announcement $announcement = null)
    {
        $this->announcement = $announcement;

        return $this;
    }

    /**
     * Get announcement
     *
     * @return \AppBundle\Entity\Announcement 
     */
    public function getAnnouncement()
    {
        return $this->announcement;
    }
}
