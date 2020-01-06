<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StageRepository")
 */
class Stage
{
    public const DEPARTEMENT = [
        0 => "A.B.",
        1 => "C.D.",
        3 => "EFG"
    ];

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
     * @ORM\Column(type="integer", nullable=true)
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
     * @ORM\Column(type="integer", nullable=true)
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): string{
        return (new Slugify())->slugify($this->intitule);
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getDureeJours(): ?int
    {
        return $this->duree_jours;
    }

    public function setDureeJours(int $duree_jours): self
    {
        $this->duree_jours = $duree_jours;

        return $this;
    }

    public function getEstGratifie(): ?bool
    {
        return $this->est_gratifie;
    }

    public function setEstGratifie(bool $est_gratifie): self
    {
        $this->est_gratifie = $est_gratifie;

        return $this;
    }

    public function getGratification(): ?int
    {
        return $this->gratification;
    }

    public function setGratification(?int $gratification): self
    {
        $this->gratification = $gratification;

        return $this;
    }

    public function getNomEtud(): ?string
    {
        return $this->nom_etud;
    }

    public function setNomEtud(string $nom_etud): self
    {
        $this->nom_etud = $nom_etud;

        return $this;
    }

    public function getPrenomEtud(): ?string
    {
        return $this->prenom_etud;
    }

    public function setPrenomEtud(string $prenom_etud): self
    {
        $this->prenom_etud = $prenom_etud;

        return $this;
    }

    public function getContratPro(): ?bool
    {
        return $this->contratPro;
    }

    public function setContratPro(bool $contratPro): self
    {
        $this->contratPro = $contratPro;

        return $this;
    }

    public function getNomTuteurEnt(): ?string
    {
        return $this->nom_tuteur_ent;
    }

    public function setNomTuteurEnt(string $nom_tuteur_ent): self
    {
        $this->nom_tuteur_ent = $nom_tuteur_ent;

        return $this;
    }

    public function getPrenomTuteurEnt(): ?string
    {
        return $this->prenom_tuteur_ent;
    }

    public function setPrenomTuteurEnt(string $prenom_tuteur_ent): self
    {
        $this->prenom_tuteur_ent = $prenom_tuteur_ent;

        return $this;
    }

    public function getTelTuteurEnt(): ?int
    {
        return $this->tel_tuteur_ent;
    }

    public function setTelTuteurEnt(?int $tel_tuteur_ent): self
    {
        $this->tel_tuteur_ent = $tel_tuteur_ent;

        return $this;
    }

    public function getMailVisible(): ?bool
    {
        return $this->mail_visible;
    }

    public function setMailVisible(bool $mail_visible): self
    {
        $this->mail_visible = $mail_visible;

        return $this;
    }

    public function getMailTuteurEnt(): ?string
    {
        return $this->mail_tuteur_ent;
    }

    public function setMailTuteurEnt(string $mail_tuteur_ent): self
    {
        $this->mail_tuteur_ent = $mail_tuteur_ent;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getRecap(): ?string
    {
        return $this->recap;
    }

    public function setRecap(?string $recap): self
    {
        $this->recap = $recap;

        return $this;
    }

    public function getEmbauche(): ?bool
    {
        return $this->embauche;
    }

    public function setEmbauche(bool $embauche): self
    {
        $this->embauche = $embauche;

        return $this;
    }

    public function getPromo(): ?int
    {
        return $this->promo;
    }

    public function setPromo(int $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    public function getAnneeForm(): ?int
    {
        return $this->annee_form;
    }
    public function getAnneeFormType(): string{
        return self::ANNEE_FORM[$this->annee_form];
    }


    public function setAnneeForm(int $annee_form): self
    {
        $this->annee_form = $annee_form;

        return $this;
    }

    public function getDepartement(): ?int
    {
        return $this->departement;
    }
    public function getDepartementType(): string{
        return self::DEPARTEMENT[$this->departement];
    }

    public function setDepartement(int $departement): self
    {
        $this->departement = $departement;

        return $this;
    }
}
