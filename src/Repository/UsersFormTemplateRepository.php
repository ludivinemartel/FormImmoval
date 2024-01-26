<?php

namespace App\Repository;

use App\Entity\UsersFormTemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UsersFormTemplate>
 *
 * @method UsersFormTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersFormTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersFormTemplate[]    findAll()
 * @method UsersFormTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersFormTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsersFormTemplate::class);
    }

//    /**
//     * @return UsersFormTemplate[] Returns an array of UsersFormTemplate objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UsersFormTemplate
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
