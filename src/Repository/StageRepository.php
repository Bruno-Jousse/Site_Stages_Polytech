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
            $query = $query->where("s.annee = :p")
                ->setParameter("p", $search->getAnnee());
        }
        if ($search->getEmbauche()){
            $query = $query->where("s.embauche = :p")
                ->setParameter("p", $search->getEmbauche());
        }
        if ($search->getAnneeForm()){
            $annee = array_search($search->getAnneeForm(), Stage::ANNEE_FORM);
            $query = $query->where("s.annee_form = :p")
                ->setParameter("p", $annee);
        }
        if ($search->getDepartement()){
            $departement = array_search($search->getDepartement(), Stage::DEPARTEMENT);
            $query = $query->where("s.departement = :p")
                ->setParameter("p", $departement);
        }
        if ($search->getMotsCle()){
            $query = $query->innerJoin("s.motsCle", "mc")
                ->where("mc.motCle = :p")
                ->setParameter("p", $search->getAnnee());
        }
        if ($search->getPromo()){
        $query = $query->where("s.promo = :p")
            ->setParameter("p", $search->getPromo());
        }
        if ($search->getThemes()){
            $query =  $query->innerJoin("s.themes", "t")
                ->where("t.theme = :p")
                ->setParameter("p", $search->getThemes());
        }
        if ($search->getContratPro()){
            $query = $query->where("s.contratPro = :p")
                ->setParameter("p", $search->getContratPro());
        }
        if ($search->getDureeJoursMax()){
            $query = $query->where("s.duree_jours <= :p")
                ->setParameter("p", $search->getDureeJoursMax());
        }
        if ($search->getDureeJoursMin()){
            $query = $query->where("s.duree_jours >= :p")
                ->setParameter("p", $search->getDureeJoursMin());
        }
        if ($search->getEntreprise()){
            $query =  $query->innerJoin("s.entreprise", "e")
                ->where("e.nom = :p")
                ->setParameter("p", $search->getEntreprise());
        }
        if ($search->getEstGratifie()){
            $query = $query->where("s.est_gratifie = :p")
                ->setParameter("p", $search->getEstGratifie());
        }
        if ($search->getLocalisation()){
            $query =  $query->innerJoin("s.adresse", "a")
                ->where($query->expr()->orX(
                    $query->expr()->like("a.adresse", ":pLike"),
                    $query->expr()->eq("a.ville", ":p"),
                    $query->expr()->eq("a.pays", ":p"),
                    $query->expr()->eq("a.continent", ":p"),
                    $query->expr()->eq("a.code_postal", ":p")
                ))
                ->setParameters(array("p" => $search->getLocalisation(), "pLike"=> "%".$search->getLocalisation()."%"));
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
