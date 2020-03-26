<?php

namespace App\Repository;

use App\Entity\MotCle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MotCle|null find($id, $lockMode = null, $lockVersion = null)
 * @method MotCle|null findOneBy(array $criteria, array $orderBy = null)
 * @method MotCle[]    findAll()
 * @method MotCle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotCleRepository extends ServiceEntityRepository
{
    /**
     * MotCleRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MotCle::class);
    }

    /**
     * Retourne un mot-clé correspondant au mot-clé fourni en paramètre (permet de savoir si un mot-clé existe déjà)
     *
     * @param MotCle $motCle
     * @return MotCle|null
     */
    public function findMotCle(MotCle $motCle){
        return $this->findOneBy(array(
            "mot_cle" => $motCle->getMotCle()
        ));
    }
}
