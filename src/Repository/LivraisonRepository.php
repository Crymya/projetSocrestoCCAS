<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Livraison;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livraison>
 *
 * @method Livraison|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livraison|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livraison[]    findAll()
 * @method Livraison[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivraisonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livraison::class);
    }

    public function save(Livraison $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Livraison $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findSearchByDate(SearchData $search): Paginator
    {
        $querybuilder = $this
            ->createQueryBuilder('l')
            ->orderBy('l.dateLivraison', 'DESC');

        if ($search->dateDebut != null)
        {
            $querybuilder
                ->andWhere("l.dateLivraison >= '" . $search->dateDebut->format('Y-m-d') . "'");
        }

        if ($search->dateFin != null)
        {
            $querybuilder
                ->andWhere("l.dateLivraison <= '" . $search->dateFin->format('Y-m-d') . "'");
        }

        $query = $querybuilder->getQuery();
        $query->setMaxResults(20);

        $paginator = new Paginator($query);

        return $paginator;
    }

}
