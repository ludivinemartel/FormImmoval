<?php

namespace App\Repository;

use App\Entity\Negociateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Negociateur>
 *
 * @method Negociateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Negociateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Negociateur[]    findAll()
 * @method Negociateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NegociateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Negociateur::class);
    }

//    /**
//     * @return Negociateur[] Returns an array of Negociateur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Negociateur
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
