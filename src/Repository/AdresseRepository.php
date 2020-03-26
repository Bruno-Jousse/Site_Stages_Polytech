<?php

namespace App\Repository;

use App\Entity\Adresse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Adresse|null find($id, $lockMode = null, $lockVersion = null)
 * @method Adresse|null findOneBy(array $criteria, array $orderBy = null)
 * @method Adresse[]    findAll()
 * @method Adresse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdresseRepository extends ServiceEntityRepository
{
    /**
     * AdresseRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adresse::class);
    }

    /**
     * Retourne une adresse correspondant à l'adresse fournie en paramètre (permet de savoir si une adresse existe déjà)
     *
     * @param Adresse $adresse
     * @return Adresse|null
     */
    public function findAdresse(Adresse $adresse){
        return $this->findOneBy(array(
            "adresse" => $adresse->getAdresse(),
            "adresse_suite" => $adresse->getAdresseSuite(),
            "ville" => $adresse->getVille(),
            "pays" => $adresse->getPays(),
            "continent" => $adresse->getContinent(),
            "code_postal" => $adresse->getCodePostal()
            //"latitude" => $adresse->getLatitude(),
            //"longitude" => $adresse->getLongitude()
        ));
    }
}
