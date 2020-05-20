<?php

namespace App\Entity;

use App\Repository\CardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CardRepository::class)
 */
class Card
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $theme;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $misteryIdentity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attention;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $crack;

    /**
     * @ORM\OneToMany(targetEntity=PowerTag::class, mappedBy="card")
     */
    private $powerTag;

    /**
     * @ORM\OneToMany(targetEntity=WeaknessTag::class, mappedBy="card")
     */
    private $weaknessTag;

    /**
     * @ORM\OneToMany(targetEntity=Improvement::class, mappedBy="card")
     */
    private $improvement;

    /**
     * @ORM\ManyToOne(targetEntity=Character::class, inversedBy="card")
     */
    private $charac;

    public function __construct($type, $theme, $title, $misteryIdentity, $attention, $crack, $powerTag =[], $weaknessTag =[], $improvement = [] )
    {
        $this->type = $type;
        $this->theme = $theme;
        $this->title = $title;
        $this->misteryIdentity = $misteryIdentity;
        $this->attention = $attention;
        $this->crack = $crack;
        $this->powerTag = new ArrayCollection();
        $this->powerTag = $powerTag;
        $this->weaknessTag = new ArrayCollection();
        $this->weaknessTag = $weaknessTag;
        $this->improvement = new ArrayCollection();
        $this->improvement = $improvement;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getMisteryIdentity(): ?string
    {
        return $this->misteryIdentity;
    }

    public function setMisteryIdentity(string $misteryIdentity): self
    {
        $this->misteryIdentity = $misteryIdentity;

        return $this;
    }

    public function getAttention(): ?string
    {
        return $this->attention;
    }

    public function setAttention(?string $attention): self
    {
        $this->attention = $attention;

        return $this;
    }

    public function getCrack(): ?string
    {
        return $this->crack;
    }

    public function setCrack(?string $crack): self
    {
        $this->crack = $crack;

        return $this;
    }

    /**
     * @return Collection|PowerTag[]
     */
    public function getPowerTag(): Collection
    {
        return $this->powerTag;
    }

    public function addPowerTag(PowerTag $powerTag): self
    {
        if (!$this->powerTag->contains($powerTag)) {
            $this->powerTag[] = $powerTag;
            $powerTag->setCard($this);
        }

        return $this;
    }

    public function removePowerTag(PowerTag $powerTag): self
    {
        if ($this->powerTag->contains($powerTag)) {
            $this->powerTag->removeElement($powerTag);
            // set the owning side to null (unless already changed)
            if ($powerTag->getCard() === $this) {
                $powerTag->setCard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|WeaknessTag[]
     */
    public function getWeaknessTag(): Collection
    {
        return $this->weaknessTag;
    }

    public function addWeaknessTag(WeaknessTag $weaknessTag): self
    {
        if (!$this->weaknessTag->contains($weaknessTag)) {
            $this->weaknessTag[] = $weaknessTag;
            $weaknessTag->setCard($this);
        }

        return $this;
    }

    public function removeWeaknessTag(WeaknessTag $weaknessTag): self
    {
        if ($this->weaknessTag->contains($weaknessTag)) {
            $this->weaknessTag->removeElement($weaknessTag);
            // set the owning side to null (unless already changed)
            if ($weaknessTag->getCard() === $this) {
                $weaknessTag->setCard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Improvement[]
     */
    public function getImprovement(): Collection
    {
        return $this->improvement;
    }

    public function addImprovement(Improvement $improvement): self
    {
        if (!$this->improvement->contains($improvement)) {
            $this->improvement[] = $improvement;
            $improvement->setCard($this);
        }

        return $this;
    }

    public function removeImprovement(Improvement $improvement): self
    {
        if ($this->improvement->contains($improvement)) {
            $this->improvement->removeElement($improvement);
            // set the owning side to null (unless already changed)
            if ($improvement->getCard() === $this) {
                $improvement->setCard(null);
            }
        }

        return $this;
    }

    public function getCharac(): ?Character
    {
        return $this->charac;
    }

    public function setCharac(?Character $charac): self
    {
        $this->charac = $charac;

        return $this;
    }
}
