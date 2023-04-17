<?php

namespace App\Repository;

use App\Entity\TachePrevue;
use App\Entity\TypePeriode;
use App\Entity\Zone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TachePrevue>
 *
 * @method TachePrevue|null find($id, $lockMode = null, $lockVersion = null)
 * @method TachePrevue|null findOneBy(array $criteria, array $orderBy = null)
 * @method TachePrevue[]    findAll()
 * @method TachePrevue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TachePrevueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TachePrevue::class);
    }

    public function save(TachePrevue $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TachePrevue $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getTaches(Zone $zone, TypePeriode $periode)
    {
        $qb = $this->createQueryBuilder('tp')
            ->andWhere('tp.zone = :zone')
            ->setParameter('zone', $zone)
            ->andWhere('tp.periode = :periode')
            ->setParameter('periode', $periode);

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return TachePrevue[] Returns an array of TachePrevue objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TachePrevue
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
