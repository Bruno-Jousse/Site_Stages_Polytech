<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MotCleRepository")
 * @UniqueEntity("motCle")
 */
class MotCle
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
    private $motCle;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Stage", mappedBy="motsCles", cascade={"persist"})
     */
    private $stages;

    /**
     * MotCle constructor.
     */
    public function __construct()
    {
        $this->stages = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getMotCle(): ?string
    {
        return $this->motCle;
    }

    /**
     * @param string $motCle
     * @return $this
     */
    public function setMotCle(string $motCle): self
    {
        $this->motCle = $motCle;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    /**
     * @param Stage $stage
     * @return $this
     */
    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->addMotsCle($this);
        }

        return $this;
    }

    /**
     * @param Stage $stage
     * @return $this
     */
    public function removeStage(Stage $stage): self
    {
        if ($this->stages->contains($stage)) {
            $this->stages->removeElement($stage);
            $stage->removeMotsCle($this);
        }

        return $this;
    }
}
