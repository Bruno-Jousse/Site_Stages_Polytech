<?php

namespace App\Repository;

use App\Entity\Search\StageSearch;
use App\Entity\Stage;
use App\Entity\Theme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

    public function filtrerStages(StageSearch $search, ThemeRepository $themeRepo) : array
    {
        $query = $this->createQueryBuilder("s");

        if (count($search->getMotsCles()) > 0){
            $query = $query->innerJoin("s.motsCles", "mc");
            $query->andWhere("mc.id in (:motsCles_id)")
                ->setParameter("motsCles_id", $search->getMotsCles());
        }
        if (count($search->getThemes()) > 0){
            $themes = array();

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

        if ($search->getAnnee()){
            $query->andWhere("s.annee = :annee")
                ->setParameter("annee", $search->getAnnee());
        }
        if ($search->getEmbauche()){
            $query->andWhere("s.embauche = :embauche")
                ->setParameter("embauche", $search->getEmbauche());
        }
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
        if ($search->getEntreprise()){
            $query =  $query->innerJoin("s.entreprise", "e");
            $query->andWhere("e.nom = :nomEnt")
                ->setParameter("nomEnt", $search->getEntreprise());
        }
        if ($search->getEstGratifie()){
            $query->andWhere("s.est_gratifie = :gratifie")
                ->setParameter("gratifie", $search->getEstGratifie());
        }

        $query =  $query->innerJoin("s.adresse", "a");
        $orX = $query->expr()->orX();
        if( $search->getVille() ){
            $orX->add($query->expr()->like("a.ville", $query->expr()->literal("%".$search->getVille()."%")));
        }
        if( $search->getPays() ){
            $orX->add($query->expr()->like("a.pays", $query->expr()->literal("%".$search->getPays()."%")));
        }
        if( $search->getContinent() ){
            $orX->add($query->expr()->like("a.continent",  $query->expr()->literal("%".$search->getContinent()."%")));
        }
        if($orX->count() >0) {
            $query->andWhere($orX);
        }
        return $query->getQuery()->getResult();
    }

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

    // /**
    //  * @return Stage[] Returns an array of Stage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
