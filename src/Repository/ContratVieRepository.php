<?php

namespace App\Repository;

use App\Entity\ContratVie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContratVie>
 *
 * @method ContratVie|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContratVie|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContratVie[]    findAll()
 * @method ContratVie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContratVieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContratVie::class);
    }

//    /**
//     * @return ContratVie[] Returns an array of ContratVie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ContratVie
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
