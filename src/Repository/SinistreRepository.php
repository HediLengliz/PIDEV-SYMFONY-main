<?php

namespace App\Repository;

use App\Entity\Sinistre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sinistre>
 *
 * @method Sinistre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sinistre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sinistre[]    findAll()
 * @method Sinistre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SinistreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sinistre::class);
    }

//    /**
//     * @return Sinister[] Returns an array of Sinister objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sinister
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
