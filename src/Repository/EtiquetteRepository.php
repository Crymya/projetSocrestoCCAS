<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Etiquette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Etiquette>
 *
 * @method Etiquette|null find($id, $lockMode = null, $lockVersion = null)
 * @method Etiquette|null findOneBy(array $criteria, array $orderBy = null)
 * @method Etiquette[]    findAll()
 * @method Etiquette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtiquetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etiquette::class);
    }

    public function save(Etiquette $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Etiquette $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findSearchByDate(SearchData $search): Paginator
    {
        $querybuilder = $this
            ->createQueryBuilder('e')
            ->orderBy('e.jourUtilise', 'DESC');

        if ($search->dateDebut != null)
        {
            $querybuilder
                ->andWhere("e.jourUtilise >= '" . $search->dateDebut->format('Y-m-d') . "'");
        }

        if ($search->dateFin != null)
        {
            $querybuilder
                ->andWhere("e.jourUtilise <= '" . $search->dateFin->format('Y-m-d') . "'");
        }

        $query = $querybuilder->getQuery();
        $query->setMaxResults(20);

        $paginator = new Paginator($query);

        return $paginator;
    }
}
