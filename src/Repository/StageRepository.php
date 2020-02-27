<?php

namespace App\Repository;

use App\Entity\Search\StageSearch;
use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

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

    public function filtrerStages(StageSearch $search) : array
    {
        $query = $this->createQueryBuilder("s");
        if ($search->getAnnee()){
            $query->andWhere("s.annee = :p")
                ->setParameter("p", $search->getAnnee());
        }
        if ($search->getEmbauche()){
            $query->andWhere("s.embauche = :p")
                ->setParameter("p", $search->getEmbauche());
        }
        if ($search->getAnneeForm()){
            $annee = array_search($search->getAnneeForm(), Stage::ANNEE_FORM);
            $query->andWhere("s.annee_form = :p")
                ->setParameter("p", $annee);
        }
        if ($search->getDepartement()){
            $departement = array_search($search->getDepartement(), Stage::DEPARTEMENT);
            $query->andWhere("s.departement = :p")
                ->setParameter("p", $departement);
        }
        if ($search->getMotsCle()){
            $query = $query->innerJoin("s.motsCle", "mc");
            $query->andWhere("mc.motCle = :p")
                ->setParameter("p", $search->getAnnee());
        }
        if ($search->getPromo()){
            $query->andWhere("s.promo = :p")
                ->setParameter("p", $search->getPromo());
        }
        if ($search->getThemes()){
            $query =  $query->innerJoin("s.themes", "t");
            $query->andWhere("t.theme = :p")
                ->setParameter("p", $search->getThemes());
        }
        if ($search->getContratPro()){
            $query->andWhere("s.contratPro = :p")
                ->setParameter("p", $search->getContratPro());
        }
        if ($search->getDureeJoursMax()){
            $query->andWhere("s.duree_jours <= :p")
                ->setParameter("p", $search->getDureeJoursMax());
        }
        if ($search->getDureeJoursMin()){
            $query->andWhere("s.duree_jours >= :p")
                ->setParameter("p", $search->getDureeJoursMin());
        }
        if ($search->getEntreprise()){
            $query =  $query->innerJoin("s.entreprise", "e");
            $query->andWhere("e.nom = :p")
                ->setParameter("p", $search->getEntreprise());
        }
        if ($search->getEstGratifie()){
            $query->andWhere("s.est_gratifie = :p")
                ->setParameter("p", $search->getEstGratifie());
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
