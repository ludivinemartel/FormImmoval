<?php

namespace App\Repository;

use App\Entity\FormResponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FormReponse>
 *
 * @method FormReponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormReponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormReponse[]    findAll()
 * @method FormReponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormResponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormResponse::class);
    }

    public function countDistinctFormResponseIds(): int
{
    return $this->createQueryBuilder('f')
        ->select('COUNT(DISTINCT f.formResponseId)')
        ->getQuery()
        ->getSingleScalarResult();
}

public function countMandats(): int
{
    return $this->createQueryBuilder('f')
        ->select('COUNT(f.id)')
        ->where('f.mandatDate IS NOT NULL')
        ->getQuery()
        ->getSingleScalarResult();
}

public function countVentes(): int
{
    return $this->createQueryBuilder('f')
        ->select('COUNT(f.id)')
        ->where('f.venteDate IS NOT NULL')
        ->getQuery()
        ->getSingleScalarResult();
}

public function countEstimationFormSubmissionsThisMonth(): int
{
    $startDate = new \DateTime('first day of this month');
    $endDate = new \DateTime('last day of this month');
    $estimationFormId = 2; // 2 = ID du formulaire d'estimation
    
    return $this->createQueryBuilder('fr')
        ->select('COUNT(DISTINCT fr.formResponseId)')
        ->andWhere('fr.FormTemplateTitle = :formTemplateId')
        ->andWhere('fr.Date BETWEEN :startDate AND :endDate')
        ->setParameter('formTemplateId', $estimationFormId)
        ->setParameter('startDate', $startDate)
        ->setParameter('endDate', $endDate)
        ->getQuery()
        ->getSingleScalarResult();
}

//    /**
//     * @return FormReponse[] Returns an array of FormReponse objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FormReponse
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
