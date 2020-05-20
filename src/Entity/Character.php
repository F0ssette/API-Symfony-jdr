<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CharacterRepository::class)
 * @ORM\Table(name="`character`")
 */
class Character
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $buildUp;

    /**
     * @ORM\OneToMany(targetEntity=Nemesis::class, mappedBy="charac")
     */
    private $nemesis;

    /**
     * @ORM\OneToMany(targetEntity=StoryTag::class, mappedBy="charac")
     */
    private $storyTag;

    /**
     * @ORM\OneToMany(targetEntity=Card::class, mappedBy="charac")
     */
    private $card;

    public function __construct($name, $picture, $buildUp, $nemesis = [], $storyTag = [], $card =[])
    {
        $this->name = $name;
        $this->picture = $picture;
        $this->buildUp = $buildUp;
        $this->nemesis = new ArrayCollection();
        $this->nemesis = $nemesis;
        $this->storyTag = new ArrayCollection();
        $this->storyTag = $storyTag;
        $this->card = new ArrayCollection();
        $this->card = $card;
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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getBuildUp(): ?string
    {
        return $this->buildUp;
    }

    public function setBuildUp(?string $buildUp): self
    {
        $this->buildUp = $buildUp;

        return $this;
    }

    /**
     * @return Collection|Nemesis[]
     */
    public function getNemesis(): Collection
    {
        return $this->nemesis;
    }

    public function addNemesi(Nemesis $nemesi): self
    {
        if (!$this->nemesis->contains($nemesi)) {
            $this->nemesis[] = $nemesi;
            $nemesi->setCharac($this);
        }

        return $this;
    }

    public function removeNemesi(Nemesis $nemesi): self
    {
        if ($this->nemesis->contains($nemesi)) {
            $this->nemesis->removeElement($nemesi);
            // set the owning side to null (unless already changed)
            if ($nemesi->getCharac() === $this) {
                $nemesi->setCharac(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|StoryTag[]
     */
    public function getStoryTag(): Collection
    {
        return $this->storyTag;
    }

    public function addStoryTag(StoryTag $storyTag): self
    {
        if (!$this->storyTag->contains($storyTag)) {
            $this->storyTag[] = $storyTag;
            $storyTag->setCharac($this);
        }

        return $this;
    }

    public function removeStoryTag(StoryTag $storyTag): self
    {
        if ($this->storyTag->contains($storyTag)) {
            $this->storyTag->removeElement($storyTag);
            // set the owning side to null (unless already changed)
            if ($storyTag->getCharac() === $this) {
                $storyTag->setCharac(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Card[]
     */
    public function getCard(): Collection
    {
        return $this->card;
    }

    public function addCard(Card $card): self
    {
        if (!$this->card->contains($card)) {
            $this->card[] = $card;
            $card->setCharac($this);
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->card->contains($card)) {
            $this->card->removeElement($card);
            // set the owning side to null (unless already changed)
            if ($card->getCharac() === $this) {
                $card->setCharac(null);
            }
        }

        return $this;
    }
}
