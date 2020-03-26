<?php

namespace App\Entity\Search;


class StageSearch
{
    /**
     * @var int|null
     */
    private $annee;

    /**
     * @var int|null
     */
    private $duree_mois_min;

    /**
     * @var int|null
     */
    private $duree_mois_max;

    /**
     * @var bool|null
     */
    private $est_gratifie = false;

    /**
     * @var bool|null
     */
    private $contratPro = false;

    /**
     * @var bool|null
     */
    private $embauche = false;

    /**
     * @var int|null
     */
    //Seulement pour les responsables
    private $promo;

    /**
     * @var string|null
     */
    //Seulement pour les responsables
    private $annee_form;

    /**
     * @var string|null
     */
    //Seulement pour les responsables
    private $departement;

    /**
     * @var string|null
     */
    private $ville;

    /**
     * @var string|null
     */
    private $pays;

    /**
     * @var string|null
     */
    private $continent;


    /**
     * @var  string|null
     */
    private $entreprise;

    /**
     * @var array|null
     */
    private $motsCles;

    /**
     * @var array|null
     */
    private $themes;

    public function __construct()
    {
        $this->motsCles = array();
        $this->themes = array();
    }

    /**
     * @return int|null
     */
    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    /**
     * @param int|null $annee
     */
    public function setAnnee(?int $annee): void
    {
        $this->annee = $annee;
    }

    /**
     * @return int|null
     */
    public function getDureeMoisMin(): ?int
    {
        return $this->duree_mois_min;
    }

    /**
     * @param int|null $duree_mois_min
     */
    public function setDureeMoisMin(?int $duree_mois_min): void
    {
        $this->duree_mois_min = $duree_mois_min;
    }

    /**
     * @return int|null
     */
    public function getDureeMoisMax(): ?int
    {
        return $this->duree_mois_max;
    }

    /**
     * @param int|null $duree_mois_max
     */
    public function setDureeMoisMax(?int $duree_mois_max): void
    {
        $this->duree_mois_max = $duree_mois_max;
    }

    /**
     * @return bool|null
     */
    public function getEstGratifie(): ?bool
    {
        return $this->est_gratifie;
    }

    /**
     * @param bool|null $est_gratifie
     */
    public function setEstGratifie(?bool $est_gratifie): void
    {
        $this->est_gratifie = $est_gratifie;
    }

    /**
     * @return bool|null
     */
    public function getContratPro(): ?bool
    {
        return $this->contratPro;
    }

    /**
     * @param bool|null $contratPro
     */
    public function setContratPro(?bool $contratPro): void
    {
        $this->contratPro = $contratPro;
    }

    /**
     * @return bool|null
     */
    public function getEmbauche(): ?bool
    {
        return $this->embauche;
    }

    /**
     * @param bool|null $embauche
     */
    public function setEmbauche(?bool $embauche): void
    {
        $this->embauche = $embauche;
    }

    /**
     * @return int|null
     */
    public function getPromo(): ?int
    {
        return $this->promo;
    }

    /**
     * @param int|null $promo
     */
    public function setPromo(?int $promo): void
    {
        $this->promo = $promo;
    }

    /**
     * @return string|null
     */
    public function getAnneeForm(): ?string
    {
        return $this->annee_form;
    }

    /**
     * @param string|null $annee_form
     */
    public function setAnneeForm(?string $annee_form): void
    {
        $this->annee_form = $annee_form;
    }

    /**
     * @return string|null
     */
    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    /**
     * @param string|null $departement
     */
    public function setDepartement(?string $departement): void
    {
        $this->departement = $departement;
    }

    /**
     * @return string|null
     */
    public function getEntreprise(): ?string
    {
        return $this->entreprise;
    }

    /**
     * @param string|null $entreprise
     */
    public function setEntreprise(?string $entreprise): void
    {
        $this->entreprise = $entreprise;
    }

    /**
     * @return array|null
     */
    public function getMotsCles(): ?array
    {
        return $this->motsCles;
    }

    /**
     * @param array|null $motsCles
     */
    public function setMotsCles(?array $motsCles): void
    {
        $this->motsCles = $motsCles;
    }

    /**
     * @return array|null
     */
    public function getThemes(): ?array
    {
        return $this->themes;
    }

    /**
     * @param array|null $themes
     */
    public function setThemes(?array $themes): void
    {
        $this->themes = $themes;
    }

    /**
     * @return int|null
     */
    public function getDureeJoursMin(): ?int
    {
        return $this->duree_mois_min * 30;
    }

    /**
     * @return int|null
     */
    public function getDureeJoursMax(): ?int
    {
        return $this->duree_mois_max * 30;
    }

    /**
     * @return string|null
     */
    public function getVille(): ?string
    {
        return $this->ville;
    }

    /**
     * @param string|null $ville
     */
    public function setVille(?string $ville): void
    {
        $this->ville = $ville;
    }

    /**
     * @return string|null
     */
    public function getPays(): ?string
    {
        return $this->pays;
    }

    /**
     * @param string|null $pays
     */
    public function setPays(?string $pays): void
    {
        $this->pays = $pays;
    }

    /**
     * @return string|null
     */
    public function getContinent(): ?string
    {
        return $this->continent;
    }

    /**
     * @param string|null $continent
     */
    public function setContinent(?string $continent): void
    {
        $this->continent = $continent;
    }


}