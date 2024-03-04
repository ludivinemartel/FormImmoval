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
