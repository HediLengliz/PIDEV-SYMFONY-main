<?php

namespace App\Repository;

use App\Entity\MedicalSheet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MedicalSheet>
 *
 * @method MedicalSheet|null find($id, $lockMode = null, $lockVersion = null)
 * @method MedicalSheet|null findOneBy(array $criteria, array $orderBy = null)
 * @method MedicalSheet[]    findAll()
 * @method MedicalSheet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedicalSheetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MedicalSheet::class);
    }

//    /**
//     * @return MedicalSheet[] Returns an array of MedicalSheet objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MedicalSheet
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
