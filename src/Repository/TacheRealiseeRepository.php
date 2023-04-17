<?php

namespace App\Repository;

use App\Entity\TacheRealisee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TacheRealisee>
 *
 * @method TacheRealisee|null find($id, $lockMode = null, $lockVersion = null)
 * @method TacheRealisee|null findOneBy(array $criteria, array $orderBy = null)
 * @method TacheRealisee[]    findAll()
 * @method TacheRealisee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TacheRealiseeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TacheRealisee::class);
    }

    public function save(TacheRealisee $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TacheRealisee $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TacheRealisee[] Returns an array of TacheRealisee objects
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

//    public function findOneBySomeField($value): ?TacheRealisee
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
