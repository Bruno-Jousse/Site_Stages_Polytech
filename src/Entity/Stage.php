<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StageRepository")
 * @UniqueEntity( fields = {"sujet", "intitule", "annee", "nom_etud", "prenom_etud", "promo", "annee_form", "departement"} )
 */
class Stage
{
    //Enumération des départements
    public const DEPARTEMENT = [
        0 => "G.M",
        1 => "G.P",
        2 => "G.B",
        3 => "G.C",
        4 => "G.E"
    ];

    //Enumération des années
    public const ANNEE_FORM = [
        0 => "3A",
        1 => "4A",
        2 => "5A"
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sujet;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $intitule;

    /**
     * @ORM\Column(type="integer")
     */
    private $annee;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree_jours;

    /**
     * @ORM\Column(type="boolean")
     */
    private $est_gratifie = false;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $gratification;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_etud;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom_etud;

    /**
     * @ORM\Column(type="boolean")
     */
    private $contratPro = false;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_tuteur_ent;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom_tuteur_ent;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $tel_tuteur_ent;

    /**
     * @ORM\Column(type="boolean")
     */
    private $mail_visible = true;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail_tuteur_ent;

    /**
     * @ORM\Column(type="string", length=1023, nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $recap;

    /**
     * @ORM\Column(type="boolean")
     */
    private $embauche = false;

    /**
     * @ORM\Column(type="integer")
     */
    private $promo;

    /**
     * @ORM\Column(type="integer")
     */
    private $annee_form;

    /**
     * @ORM\Column(type="integer")
     */
    private $departement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Adresse", inversedBy="stages", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresse;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Theme", inversedBy="stages", cascade={"persist"})
     */
    private $themes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\MotCle", inversedBy="stages", cascade={"persist"})
     */
    private $motsCles;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entreprise", inversedBy="stages", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $entreprise;

    /**
     * Stage constructor.
     */
    public function __construct()
    {
        $this->themes = new ArrayCollection();
        $this->motsCles = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSlug(): string{
        return (new Slugify())->slugify($this->intitule);
    }

    /**
     * @return string|null
     */
    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    /**
     * @param string $sujet
     * @return $this
     */
    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    /**
     * @param string $intitule
     * @return $this
     */
    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    /**
     * @param int $annee
     * @return $this
     */
    public function setAnnee(int $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getDureeJours(): ?int
    {
        return $this->duree_jours;
    }

    /**
     * @param int $duree_jours
     * @return $this
     */
    public function setDureeJours(int $duree_jours): self
    {
        $this->duree_jours = $duree_jours;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getEstGratifie(): ?bool
    {
        return $this->est_gratifie;
    }

    /**
     * @param bool $est_gratifie
     * @return $this
     */
    public function setEstGratifie(bool $est_gratifie): self
    {
        $this->est_gratifie = $est_gratifie;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getGratification(): ?float
    {
        return $this->gratification;
    }

    /**
     * @param int|null $gratification
     * @return $this
     */
    public function setGratification(?int $gratification): self
    {
        $this->gratification = $gratification;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNomEtud(): ?string
    {
        return $this->nom_etud;
    }

    /**
     * @param string $nom_etud
     * @return $this
     */
    public function setNomEtud(string $nom_etud): self
    {
        $this->nom_etud = $nom_etud;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrenomEtud(): ?string
    {
        return $this->prenom_etud;
    }

    /**
     * @param string $prenom_etud
     * @return $this
     */
    public function setPrenomEtud(string $prenom_etud): self
    {
        $this->prenom_etud = $prenom_etud;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getContratPro(): ?bool
    {
        return $this->contratPro;
    }

    /**
     * @param bool $contratPro
     * @return $this
     */
    public function setContratPro(bool $contratPro): self
    {
        $this->contratPro = $contratPro;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNomTuteurEnt(): ?string
    {
        return $this->nom_tuteur_ent;
    }

    /**
     * @param string $nom_tuteur_ent
     * @return $this
     */
    public function setNomTuteurEnt(string $nom_tuteur_ent): self
    {
        $this->nom_tuteur_ent = $nom_tuteur_ent;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrenomTuteurEnt(): ?string
    {
        return $this->prenom_tuteur_ent;
    }

    /**
     * @param string $prenom_tuteur_ent
     * @return $this
     */
    public function setPrenomTuteurEnt(string $prenom_tuteur_ent): self
    {
        $this->prenom_tuteur_ent = $prenom_tuteur_ent;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTelTuteurEnt(): ?string
    {
        return $this->tel_tuteur_ent;
    }

    /**
     * @param string|null $tel_tuteur_ent
     * @return $this
     */
    public function setTelTuteurEnt(?string $tel_tuteur_ent): self
    {
        $this->tel_tuteur_ent = $tel_tuteur_ent;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getMailVisible(): ?bool
    {
        return $this->mail_visible;
    }

    /**
     * @param bool $mail_visible
     * @return $this
     */
    public function setMailVisible(bool $mail_visible): self
    {
        $this->mail_visible = $mail_visible;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMailTuteurEnt(): ?string
    {
        return $this->mail_tuteur_ent;
    }

    /**
     * @param string $mail_tuteur_ent
     * @return $this
     */
    public function setMailTuteurEnt(string $mail_tuteur_ent): self
    {
        $this->mail_tuteur_ent = $mail_tuteur_ent;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    /**
     * @param string|null $commentaire
     * @return $this
     */
    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRecap(): ?string
    {
        return $this->recap;
    }

    /**
     * @param string|null $recap
     * @return $this
     */
    public function setRecap(?string $recap): self
    {
        $this->recap = $recap;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getEmbauche(): ?bool
    {
        return $this->embauche;
    }

    /**
     * @param bool $embauche
     * @return $this
     */
    public function setEmbauche(bool $embauche): self
    {
        $this->embauche = $embauche;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPromo(): ?int
    {
        return $this->promo;
    }

    /**
     * @param int $promo
     * @return $this
     */
    public function setPromo(int $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getAnneeForm(): ?int
    {
        return $this->annee_form;
    }

    /**
     * Retourne la valeur de l'année (au lieu de la clé)
     *
     * @return string
     */
    public function getAnneeFormType(): string{
        return self::ANNEE_FORM[$this->annee_form];
    }


    /**
     * @param int $annee_form
     * @return $this
     */
    public function setAnneeForm(int $annee_form): self
    {
        $this->annee_form = $annee_form;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getDepartement(): ?int
    {
        return $this->departement;
    }

    /**
     * Retourne la valeur du département (au lieu de la clé)
     *
     * @return string
     */
    public function getDepartementType(): string{
        return self::DEPARTEMENT[$this->departement];
    }

    /**
     * @param int $departement
     * @return $this
     */
    public function setDepartement(int $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * @return Adresse|null
     */
    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    /**
     * @param Adresse|null $adresse
     * @return $this
     */
    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection|Theme[]
     */
    public function getThemes(): Collection
    {
        return $this->themes;
    }

    /**
     * @param Theme $theme
     * @return $this
     */
    public function addTheme(Theme $theme): self
    {
        if (!$this->themes->contains($theme)) {
            $this->themes[] = $theme;
        }

        return $this;
    }

    /**
     * @param Theme $theme
     * @return $this
     */
    public function removeTheme(Theme $theme): self
    {
        if ($this->themes->contains($theme)) {
            $this->themes->removeElement($theme);
        }

        return $this;
    }

    /**
     * @return Collection|MotCle[]
     */
    public function getMotsCles(): Collection
    {
        return $this->motsCles;
    }

    /**
     * @param MotCle $motsCle
     * @return $this
     */
    public function addMotsCle(MotCle $motsCle): self
    {
        if (!$this->motsCles->contains($motsCle)) {
            $this->motsCles[] = $motsCle;
        }

        return $this;
    }

    /**
     * @param MotCle $motsCle
     * @return $this
     */
    public function removeMotsCle(MotCle $motsCle): self
    {
        if ($this->motsCles->contains($motsCle)) {
            $this->motsCles->removeElement($motsCle);
        }

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
     * Retourne la clé de la valeur correspondant à l'année indiquée
     *
     * @param $string
     * @return false|int|string
     */
    public static function stringToAnneeForm($string)
    {
        $res = 0;
        switch ($string){
            case "Contrat Pro":
            case "cinquième année":
                $res = array_search("5A", self::ANNEE_FORM);
                break;
            case "quatrième année":
                $res =  array_search("4A", self::ANNEE_FORM);
                break;
            case"troisième année":
                $res = array_search("3A", self::ANNEE_FORM);
                break;
        }

        return $res;
    }

    /**
     * Retourne la clé de la valeur correspondant au département indiqué
     *
     * @param $string
     * @return false|int|string
     */
    public static function stringToDepartement($string){
        return array_search($string, self::DEPARTEMENT);
    }
}
