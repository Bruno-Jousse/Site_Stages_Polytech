<?php

namespace App\Repository;

use App\Entity\Entreprise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Entreprise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entreprise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entreprise[]    findAll()
 * @method Entreprise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrepriseRepository extends ServiceEntityRepository
{
    /**
     * EntrepriseRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entreprise::class);
    }

    /**
     * Retourne une entreprise correspondant à l'entreprise fournie en paramètre (permet de savoir si une entreprise existe déjà)
     *
     * @param Entreprise $entreprise
     * @return Entreprise|null
     */
    public function findEntreprise(Entreprise $entreprise){
        return $this->findOneBy(array(
            "nom" => $entreprise->getNom(),
            "est_privee" => $entreprise->getEstPrivee()
        ));
    }
}
