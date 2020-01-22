<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ThemeRepository")
 * @UniqueEntity("theme")
 */
class Theme
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
    private $theme;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Theme", inversedBy="themes")
     */
    private $pere;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Theme", mappedBy="pere", cascade={"persist"})
     */
    private $themes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Stage", mappedBy="themes", cascade={"persist"})
     */
    private $stages;

    public function __construct()
    {
        $this->themes = new ArrayCollection();
        $this->stages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPere(): ?self
    {
        return $this->pere;
    }

    public function setPere(?self $pere): self
    {
        $this->pere = $pere;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getThemes(): Collection
    {
        return $this->themes;
    }

    public function addTheme(self $theme): self
    {
        if (!$this->themes->contains($theme)) {
            $this->themes[] = $theme;
            $theme->setPere($this);
        }

        return $this;
    }

    public function removeTheme(self $theme): self
    {
        if ($this->themes->contains($theme)) {
            $this->themes->removeElement($theme);
            // set the owning side to null (unless already changed)
            if ($theme->getPere() === $this) {
                $theme->setPere(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->addTheme($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->contains($stage)) {
            $this->stages->removeElement($stage);
            $stage->removeTheme($this);
        }

        return $this;
    }
}
