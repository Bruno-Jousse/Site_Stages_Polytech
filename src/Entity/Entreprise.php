<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntrepriseRepository")
 * @UniqueEntity( fields = {"nom", "est_privee"} )
 */
class Entreprise
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
    private $nom;

    /**
     * @ORM\Column(type="boolean")
     */
    private $est_privee = true;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Adresse", mappedBy="entreprise", cascade={"persist", "remove"})
     */
    private $adresses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stage", mappedBy="entreprise", cascade={"persist"})
     */
    private $stages;

    /**
     * Entreprise constructor.
     */
    public function __construct()
    {
        $this->adresses = new ArrayCollection();
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
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * @return $this
     */
    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getEstPrivee(): ?bool
    {
        return $this->est_privee;
    }

    /**
     * @return string
     */
    public function getEstPriveeType(): string{
        return ($this->est_privee ? "privée" : "publique");
    }

    /**
     * @param bool $est_privee
     * @return $this
     */
    public function setEstPrivee(bool $est_privee): self
    {
        $this->est_privee = $est_privee;

        return $this;
    }

    /**
     * @return Collection|Adresse[]
     */
    public function getAdresses(): Collection
    {
        return $this->adresses;
    }

    /**
     * @param Adresse $adress
     * @return $this
     */
    public function addAdress(Adresse $adress): self
    {
        if (!$this->adresses->contains($adress)) {
            $this->adresses[] = $adress;
            $adress->setEntreprise($this);
        }

        return $this;
    }

    /**
     * @param Adresse $adress
     * @return $this
     */
    public function removeAdress(Adresse $adress): self
    {
        if ($this->adresses->contains($adress)) {
            $this->adresses->removeElement($adress);
            // set the owning side to null (unless already changed)
            if ($adress->getEntreprise() === $this) {
                $adress->setEntreprise(null);
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

    /**
     * @param Stage $stage
     * @return $this
     */
    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->setEntreprise($this);
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
            // set the owning side to null (unless already changed)
            if ($stage->getEntreprise() === $this) {
                $stage->setEntreprise(null);
            }
        }

        return $this;
    }
}
