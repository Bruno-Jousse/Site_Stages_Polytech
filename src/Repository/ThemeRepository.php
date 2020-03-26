<?php

namespace App\Repository;

use App\Entity\Theme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @method Theme|null find($id, $lockMode = null, $lockVersion = null)
 * @method Theme|null findOneBy(array $criteria, array $orderBy = null)
 * @method Theme[]    findAll()
 * @method Theme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThemeRepository extends ServiceEntityRepository
{
    /**
     * ThemeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Theme::class);
    }

    /**
     * Retourne un thème correspondant au thème fourni en paramètre (permet de savoir si un thème existe déjà)
     *
     * @param Theme $theme
     * @return Theme|null
     */
    public function findTheme(Theme $theme){
        return $this->findOneBy(array(
            "theme" => $theme->getTheme()
        ));
    }

    /**
     * Récupère tous les thèmes fils de celui donné en paramètre
     *
     * @param Theme $theme
     * @return mixed
     */
    public function getAllChildren(Theme $theme){
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('App\Entity\Theme', 't');

        $rsm->addFieldResult("t", "theme", "theme");
        $rsm->addFieldResult("t", "id", "id");
        $rsm->addFieldResult("t", "pere", "pere");

        $sql = "with recursive themes_tree as (
        SELECT id, theme, pere_id
        FROM theme
        WHERE theme = ?
        UNION ALL
            SELECT child.id, child.theme, child.pere_id
            FROM theme as child
        JOIN themes_tree as parent on parent.id = child.pere_id
        )
        select * from themes_tree";

        $query =  $this->getEntityManager()->createNativeQuery($sql, $rsm);
        $query->setParameter(1, $theme->getTheme());

        return $query->getResult();
    }
}
