<?php

namespace App\Repository;

use App\Entity\Remorqueur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Remorqueur>
 *
 * @method Remorqueur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Remorqueur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Remorqueur[]    findAll()
 * @method Remorqueur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RemorqueurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Remorqueur::class);
    }

//    /**
//     * @return Remorqueur[] Returns an array of Remorqueur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Remorqueur
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
