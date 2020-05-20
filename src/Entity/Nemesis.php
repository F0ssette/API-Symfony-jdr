<?php

namespace App\Entity;

use App\Repository\NemesisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NemesisRepository::class)
 */
class Nemesis
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
     * @ORM\ManyToOne(targetEntity=Character::class, inversedBy="nemesis")
     */
    private $charac;

    public function __construct($name)
    {
        $this->name = $name;
        // $this->charac = new ArrayCollection();
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
