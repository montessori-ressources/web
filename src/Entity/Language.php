<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LanguageRepository")
 */
class Language
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $iso2Char;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Nomenclature", mappedBy="language")
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

    public function getIso2Char(): ?string
    {
        return $this->iso2Char;
    }

    public function setIso2Char(?string $iso2Char): self
    {
        $this->iso2Char = $iso2Char;

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
            $nomenclature->setLanguage($this);
        }

        return $this;
    }

    public function removeNomenclature(Nomenclature $nomenclature): self
    {
        if ($this->nomenclatures->contains($nomenclature)) {
            $this->nomenclatures->removeElement($nomenclature);
            // set the owning side to null (unless already changed)
            if ($nomenclature->getLanguage() === $this) {
                $nomenclature->setLanguage(null);
            }
        }

        return $this;
    }
}
