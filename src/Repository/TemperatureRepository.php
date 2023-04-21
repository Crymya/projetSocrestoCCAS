<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Materiel;
use App\Entity\Temperature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
        $startDate = (clone $date)->modify('first day of this month');
        $endDate = (clone$date)->modify('last day of this month');

        return $this->createQueryBuilder('t')
            ->where('t.materiel = :materiel')
            ->andWhere('t.dateControle BETWEEN :start_date AND :end_date')
            ->setParameter('materiel', $materiel)
            ->setParameter('start_date', $startDate)
            ->setParameter('end_date', $endDate)
            ->orderBy('t.dateControle', 'ASC')
            ->getQuery()
            ->getResult();

        /*$qb = $this
            ->createQueryBuilder('t')
            ->select('t.valeur', 't.dateControle')
            ->innerJoin('t.materiel', 'm')
            ->andWhere('m.id = :id')
            ->setParameter('id', $id)
            ->orderBy('t.dateControle', 'ASC')
            ;

        $query = $qb->getQuery();
        $query->setMaxResults(62);


        return $qb->getQuery()->getResult();*/
    }
}
