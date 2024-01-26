<?php

namespace App\Repository;

use App\Entity\ProspectReponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProspectReponse>
 *
 * @method ProspectReponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProspectReponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProspectReponse[]    findAll()
 * @method ProspectReponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProspectReponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProspectReponse::class);
    }

//    /**
//     * @return ProspectReponse[] Returns an array of ProspectReponse objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProspectReponse
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
