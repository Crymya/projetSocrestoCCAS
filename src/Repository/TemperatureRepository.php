<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Materiel;
use App\Entity\Temperature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Temperature>
 *
 * @method Temperature|null find($id, $lockMode = null, $lockVersion = null)
 * @method Temperature|null findOneBy(array $criteria, array $orderBy = null)
 * @method Temperature[]    findAll()
 * @method Temperature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TemperatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Temperature::class);
    }

    public function save(Temperature $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Temperature $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findSearch(SearchData $search): Paginator
    {
        $materiel = $search->materiels;
        $count = count($materiel);


        $queryBuilder = $this
            ->createQueryBuilder('t')
            ->join('t.materiel', 'm')
            ->addSelect('m', 't')
            ->addOrderBy('t.dateControle', 'DESC');

        if ($search->dateDebut != null)
        {
            $queryBuilder
                ->andWhere("t.dateControle >= '" . $search->dateDebut->format('Y-m-d H:i') . "'");
        }

        if ($search->dateFin != null)
        {
            $queryBuilder
                ->andWhere("t.dateControle <= '" . $search->dateFin->format('Y-m-d H:i') . "'");
        }

        if (!empty($search->materiels) && $count != 0)
        {
            $queryBuilder
                ->andWhere('m.id IN (:materiels)')
                ->setParameter('materiels', $search->materiels);
        }

        $query = $queryBuilder->getQuery();
        $query->setMaxResults(60);

        $paginator = new Paginator($query);

        return $paginator;
    }

    public function findByMonthAndMateriel(Materiel $materiel, \DateTimeInterface $date)
    {
        $month = $date->format('m');

        $qb = $this->createQueryBuilder('t');
        $qb->where('t.materiel = :materiel')
            ->andWhere(new Expr\Func('MONTH', ['t.dateControle']) . ' = :month')
            ->setParameter('materiel', $materiel)
            ->setParameter('month', $month)
            ->orderBy('t.dateControle', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
