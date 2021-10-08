<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    
    /**
     * @ORM\ManyToOne(targetEntity="ProjectType" )
     * @ORM\JoinColumn(name="project_type", referencedColumnName="id")
     */
    public $projectType;


     /**
     * @ORM\Column(type="string")
     */
    public $location;

    /**
     * @ORM\Column(type="string")
     */
    private $startDate;

    /**
     * @ORM\Column(type="string")
     */
    private $endDate;

    /**
     * @ORM\Column(type="string", nullable="true")
     */
    private $information;

    /**
     * @ORM\Column(type="string", nullable="true")
     */
    private $changes;

    /**
         * @ORM\Column(type="blob")
     */
    private $profileImage;

    /**
     * @ORM\Column(type="boolean", options={"default" : true})
     */
    private $defaultImage;

    /**
     * Get the value of location
     */ 
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set the value of location
     *
     * @return  self
     */ 
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get the value of startDate
     */ 
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set the value of startDate
     *
     * @return  self
     */ 
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get the value of endDate
     */ 
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set the value of endDate
     *
     * @return  self
     */ 
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get the value of information
     */ 
    public function getInformation()
    {
        return $this->information;
    }

    /**
     * Set the value of information
     *
     * @return  self
     */ 
    public function setInformation($information)
    {
        $this->information = $information;

        return $this;
    }

    /**
     * Get the value of changes
     */ 
    public function getChanges()
    {
        return $this->changes;
    }

    /**
     * Set the value of changes
     *
     * @return  self
     */ 
    public function setChanges($changes)
    {
        $this->changes = $changes;

        return $this;
    }



    /**
     * Get the value of projectType
     */ 
    public function getProjectType()
    {
        return $this->projectType;
    }

    /**
     * Set the value of projectType
     *
     * @return  self
     */ 
    public function setProjectType($projectType)
    {
        $this->projectType = $projectType;

        return $this;
    }

    /**
     * Get the value of profileImage
     */ 
    public function getProfileImage()
    {
        return $this->profileImage;
    }

    /**
     * Set the value of profileImage
     *
     * @return  self
     */ 
    public function setProfileImage($profileImage)
    {
        $this->profileImage = $profileImage;

        return $this;
    }

    public  function  __toString()
    {
        

        return "asdsad'";
    }

    /**
     * @return mixed
     */
    public function getDefaultImage()
    {
        return $this->defaultImage;
    }

    /**
     * @param mixed $defaultImage
     */
    public function setDefaultImage($defaultImage): void
    {
        $this->defaultImage = $defaultImage;
    }


}
