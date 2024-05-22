<?php

namespace App\Repository;

use App\Entity\ContratHabitat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContratHabitat>
 *
 * @method ContratHabitat|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContratHabitat|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContratHabitat[]    findAll()
 * @method ContratHabitat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContratHabitatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContratHabitat::class);
    }

//    /**
//     * @return ContratHabitat[] Returns an array of ContratHabitat objects
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

//    public function findOneBySomeField($value): ?ContratHabitat
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
