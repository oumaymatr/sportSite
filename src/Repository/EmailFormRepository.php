<?php

namespace App\Repository;

use App\Entity\EmailForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EmailForm>
 *
 * @method EmailForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmailForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmailForm[]    findAll()
 * @method EmailForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailFormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailForm::class);
    }

//    /**
//     * @return EmailForm[] Returns an array of EmailForm objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EmailForm
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
