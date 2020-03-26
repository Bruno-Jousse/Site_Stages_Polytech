<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdresseRepository")
 * @UniqueEntity( fields = {"adresse", "adresse_suite", "code_postal", "ville", "pays"} )
 */
class Adresse
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
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse_suite = "";

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $code_postal = "";

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $longitude;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $continent;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pays;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entreprise", inversedBy="adresses", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $entreprise;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stage", mappedBy="adresse", cascade={"persist"})
     */
    private $stages;

    /**
     * Adresse constructor.
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
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     * @return $this
     */
    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAdresseSuite(): ?string
    {
        return $this->adresse_suite;
    }

    /**
     * @param string|null $adresse_suite
     * @return $this
     */
    public function setAdresseSuite(?string $adresse_suite): self
    {
        $this->adresse_suite = $adresse_suite;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    /**
     * @param string|null $code_postal
     * @return $this
     */
    public function setCodePostal(?string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getVille(): ?string
    {
        return $this->ville;
    }

    /**
     * @param string $ville
     * @return $this
     */
    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    /**
     * @param string $latitude
     * @return $this
     */
    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    /**
     * @param string $longitude
     * @return $this
     */
    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContinent(): ?string
    {
        return $this->continent;
    }

    /**
     * @param string $continent
     * @return $this
     */
    public function setContinent(string $continent): self
    {
        $this->continent = $continent;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPays(): ?string
    {
        return $this->pays;
    }

    /**
     * @param string $pays
     * @return $this
     */
    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Entreprise|null
     */
    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    /**
     * @param Entreprise|null $entreprise
     * @return $this
     */
    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

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
            $stage->setAdresse($this);
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
            if ($stage->getAdresse() === $this) {
                $stage->setAdresse(null);
            }
        }

        return $this;
    }
}
