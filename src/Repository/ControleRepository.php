<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Controle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Controle>
 *
 * @method Controle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Controle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Controle[]    findAll()
 * @method Controle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ControleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Controle::class);
    }

    public function save(Controle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Controle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findSortedAndPaginated(): Paginator
    {
        $qb = $this->createQueryBuilder('c')
            ->orderBy('c.dateControle', 'ASC');

        $query = $qb->getQuery();
        $query->setMaxResults(5);

        $paginator = new Paginator($query);

        return $paginator;
    }

    public function findSearchByDate(SearchData $search): Paginator
    {
        $querybuilder = $this
            ->createQueryBuilder('c')
            ->orderBy('c.dateControle', 'DESC');

        if ($search->dateDebut != null)
        {
            $querybuilder
                ->andWhere("c.dateControle >= '" . $search->dateDebut->format('Y-m-d') . "'");
        }

        if ($search->dateFin != null)
        {
            $querybuilder
                ->andWhere("c.dateControle <= '" . $search->dateFin->format('Y-m-d') . "'");
        }

        $query = $querybuilder->getQuery();
        $query->setMaxResults(20);

        $paginator = new Paginator($query);

        return $paginator;
    }
}
