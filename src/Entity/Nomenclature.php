<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NomenclatureRepository")
 */
class Nomenclature
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Card", mappedBy="nomenclature", cascade={"all"})
     */
    private $cards;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="nomenclatures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Language", inversedBy="nomenclatures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $language;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Mode", inversedBy="nomenclatures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mode;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\IllustrationType", inversedBy="nomenclatures")
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PictureSet", inversedBy="nomenclatures")
     */
    private $pictureSet;

    const STATUS = [
      0 => 'draft',
      1 => 'waiting-approval',
      2 => 'validated'

    ];
    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tags", mappedBy="nomenclature")
     */
    private $tags;

    public function __toString()
    {
      return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function __construct() {
        $this->createdAt = new \DateTime('now');
        $this->cards = new ArrayCollection();
        $this->pictureSet = new ArrayCollection();
        $this->status = 0;
        $this->tags = new ArrayCollection(); // draft
    }

    public function __clone() {
      $this->createdAt = new \DateTime('now');
      $this->name = $this->name.' [1]';
      $new_cards = new ArrayCollection();
      foreach ($this->cards as $card) {
        $new_card = clone $card;
        $new_card->setNomenclature($this);
        $new_cards->add($new_card);
      }
      $this->cards = $new_cards;
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
     * @return Collection|Card[]
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
            $card->setNomenclature($this);
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
            // set the owning side to null (unless already changed)
            if ($card->getNomenclature() === $this) {
                $card->setNomenclature(null);
            }
        }

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getMode(): ?Mode
    {
        return $this->mode;
    }

    public function setMode(?Mode $mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    public function getType(): ?IllustrationType
    {
        return $this->type;
    }

    public function setType(?IllustrationType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|PictureSet[]
     */
    public function getPictureSet(): Collection
    {
        return $this->pictureSet;
    }

    public function addPictureSet(PictureSet $pictureSet): self
    {
        if (!$this->pictureSet->contains($pictureSet)) {
            $this->pictureSet[] = $pictureSet;
        }

        return $this;
    }

    public function removePictureSet(PictureSet $pictureSet): self
    {
        if ($this->pictureSet->contains($pictureSet)) {
            $this->pictureSet->removeElement($pictureSet);
        }

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function getStatusName() {
      return Nomenclature::STATUS[$this->status];
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Tags[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tags $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->setNomenclature($this);
        }

        return $this;
    }

    public function removeTag(Tags $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
            // set the owning side to null (unless already changed)
            if ($tag->getNomenclature() === $this) {
                $tag->setNomenclature(null);
            }
        }

        return $this;
    }
}
