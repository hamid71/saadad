<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DisciplineRepository")
 */
class Discipline
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     htmlPattern = "^[a-zA-Z]+$"
     * )
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Software", mappedBy="discipline")
     */
    private $software;

    public function __construct()
    {
        $this->software = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Software[]
     */
    public function getSoftware(): Collection
    {
        return $this->software;
    }

    public function addSoftware(Software $software): self
    {
        if (!$this->software->contains($software)) {
            $this->software[] = $software;
            $software->setDiscipline($this);
        }

        return $this;
    }

    public function removeSoftware(Software $software): self
    {
        if ($this->software->contains($software)) {
            $this->software->removeElement($software);
            // set the owning side to null (unless already changed)
            if ($software->getDiscipline() === $this) {
                $software->setDiscipline(null);
            }
        }

        return $this;
    }
    public function __toString(){
        // to show the name of the Category in the select
        return $this->name;
        // to show the id of the Category in the select
        // return $this->id;
    }
}
