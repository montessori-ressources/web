<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IllustrationTypeRepository")
 */
class IllustrationType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Nomenclature", mappedBy="type")
     */
    private $nomenclatures;

    public function __construct()
    {
        $this->nomenclatures = new ArrayCollection();
    }

    public function getId(): ?int
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
     * @return Collection|Nomenclature[]
     */
    public function getNomenclatures(): Collection
    {
        return $this->nomenclatures;
    }

    public function addNomenclature(Nomenclature $nomenclature): self
    {
        if (!$this->nomenclatures->contains($nomenclature)) {
            $this->nomenclatures[] = $nomenclature;
            $nomenclature->setType($this);
        }

        return $this;
    }

    public function removeNomenclature(Nomenclature $nomenclature): self
    {
        if ($this->nomenclatures->contains($nomenclature)) {
            $this->nomenclatures->removeElement($nomenclature);
            // set the owning side to null (unless already changed)
            if ($nomenclature->getType() === $this) {
                $nomenclature->setType(null);
            }
        }

        return $this;
    }
}
