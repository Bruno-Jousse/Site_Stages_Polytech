<?php

namespace App\Repository;

use App\Entity\Search\StageSearch;
use App\Entity\Stage;
use App\Entity\Theme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{

    /**
     * StageRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

    /**
     * Permet de récupérer les stages correspondants aux critères de recherche fournis en paramètre
     *
     * @param StageSearch $search
     * @param ThemeRepository $themeRepo
     * @return array
     */
    public function filtrerStages(StageSearch $search, ThemeRepository $themeRepo) : array
    {
        $query = $this->createQueryBuilder("s");

        //Si des mots-clés sont donnés, on cherche les stages contenant au moins un des mots-clés
        if (count($search->getMotsCles()) > 0){
            $query = $query->innerJoin("s.motsCles", "mc");
            $query->andWhere("mc.id in (:motsCles_id)")
                ->setParameter("motsCles_id", $search->getMotsCles());
        }

        //Si des thèmes sont donnés, on cherche les stages contenant au moins un des thèmes ou un de ses fils
        if (count($search->getThemes()) > 0){
            $themes = array();

            //Récupère les fils des thèmes donnés
            foreach ($search->getThemes() as $theme) {
                $children = $themeRepo->getAllChildren($theme);
                foreach ($children as $child){
                    array_push($themes, $child);
                }
            }

            $query = $query->innerJoin("s.themes", "t");
            $query->andWhere("t.id in (:themes_id)")
                ->setParameter("themes_id", $themes);
        }

        //On récupère les stages correspondants aux critères fournis
        if ($search->getAnnee()){
            $this->multipleElementsQuery($query, $search->getAnnee(), "s.annee");

        }
        if ($search->getEmbauche()){
            $query->andWhere("s.embauche = :embauche")
                ->setParameter("embauche", $search->getEmbauche());
        }
        if ($search->getContratPro()){
            $query->andWhere("s.contratPro = :contratPro")
                ->setParameter("contratPro", $search->getContratPro());
        }
        if ($search->getDureeJoursMax()){
            $query->andWhere("s.duree_jours <= :dureeJoursMax")
                ->setParameter("dureeJoursMax", $search->getDureeJoursMax());
        }
        if ($search->getDureeJoursMin()){
            $query->andWhere("s.duree_jours >= :dureeJoursMin")
                ->setParameter("dureeJoursMin", $search->getDureeJoursMin());
        }

        //TODO: Filtrer en fonction de l'année et du département de l'utilisateur
        if ($search->getAnneeForm()){
            $annee = array_search($search->getAnneeForm(), Stage::ANNEE_FORM);
            $query->andWhere("s.annee_form = :anneeForm")
                ->setParameter("anneeForm", $annee);
        }
        if ($search->getDepartement()){
            $departement = array_search($search->getDepartement(), Stage::DEPARTEMENT);
            $query->andWhere("s.departement = :departement")
                ->setParameter("departement", $departement);
        }
        if ($search->getPromo()){
            $query->andWhere("s.promo = :promo")
                ->setParameter("promo", $search->getPromo());
        }

        if ($search->getEntreprise()){
            $query =  $query->innerJoin("s.entreprise", "e");

            $this->multipleElementsQuery($query, $search->getEntreprise(), "e.nom");
        }
        if ($search->getEstGratifie()){
            $query->andWhere("s.est_gratifie = :gratifie")
                ->setParameter("gratifie", $search->getEstGratifie());
        }

        $query =  $query->innerJoin("s.adresse", "a");
        $orX = $query->expr()->orX();
        //Le stage doit correspondre au moins à la ville, au pays OU au continent
        if( $search->getVille() ){
            $expression = $this->multipleElementsExpression($query, $search->getVille(), "a.ville");
            if($expression->count() > 0){
                $orX->add($expression);
            }
        }
        if( $search->getPays() ){
            $expression = $this->multipleElementsExpression($query, $search->getPays(), "a.pays");
            if($expression->count() > 0){
                $orX->add($expression);
            }
        }
        if( $search->getContinent() ){
            $expression = $this->multipleElementsExpression($query, $search->getContinent(), "a.continent");
            if($expression->count() > 0){
                $orX->add($expression);
            }
        }
        if($orX->count() >0) {
            $query->andWhere($orX);
        }
        return $query->getQuery()->getResult();
    }


    /**
     * Prend en paramètre une query, une string contenant une liste d'éléments séparés par un ";" et le nom d'une colonne en base de données
     * Ajoute à la query la sélection d'un stage en s'assurant qu'il possède au moins un des éléments de la liste.
     *
     * @param QueryBuilder $query
     * @param string $stringElements
     * @param string $colonne
     * @return QueryBuilder
     */
    private function multipleElementsQuery(QueryBuilder $query, string $stringElements, string $colonne){

        $orX = $this->multipleElementsExpression($query, $stringElements, $colonne);

        if($orX->count() >0) {
            $query->andWhere($orX);
        }

        return $query;
    }

    /**
     * Prend en paramètre une query, une string contenant une liste d'éléments séparés par un ";" et le nom d'une colonne en base de données
     * Retourne une query permettant de chercher les stages correspondant à au moins un des éléments de la liste.
     *
     * @param QueryBuilder $query
     * @param string $stringElements
     * @param string $colonne
     * @return Query\Expr\Orx
     */
    private function multipleElementsExpression(QueryBuilder $query, string $stringElements, string $colonne){
        $elements = explode(";", $stringElements);

        $orX = $query->expr()->orX();

        foreach ($elements as $element){
            $element = trim($element);
            $orX->add($query->expr()->like($colonne, $query->expr()->literal("%".$element."%")));
        }

        return $orX;
    }

    /**
     * Retourne un stage correspondant au stage fourni en paramètre (permet de savoir si un stage existe déjà)
     *
     * @param Stage $stage
     * @return Stage|null
     */
    public function findStage(Stage $stage){
        return $this->findOneBy(array(
            "annee" => $stage->getAnnee(),
            "annee_form" => $stage->getAnneeForm(),
            "departement" => $stage->getDepartement(),
            "promo" => $stage->getPromo(),
            "nom_etud" => $stage->getNomEtud(),
            "prenom_etud" => $stage->getPrenomEtud(),
            //"intitule" => $stage->getIntitule(),
            "sujet" => $stage->getSujet()
        ));
    }
}
