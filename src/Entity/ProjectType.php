<?php

namespace App\Entity;

use App\Repository\ProjectTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectTypeRepository::class)
 */
class ProjectType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

     /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $englishName;


    public function getId(): ?int
    {
        return $this->id;
    }






    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEnglishName()
    {
        return $this->englishName;
    }

    /**
     * @param mixed $englishName
     */
    public function setEnglishName($englishName): void
    {
        $this->englishName = $englishName;
    }



    public function __toString(){
        return $this->name;
    }


}
