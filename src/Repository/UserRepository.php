<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Search;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

//    /**
//     * @return User[] Returns an array of User objects
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

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
        public function findDistinctDepartements()
        {
            return $this->createQueryBuilder('u')
                ->select('DISTINCT u.departement')
                ->getQuery()
                ->getResult();
        }
         // Ajoutez la méthode de recherche
    public function findBySearchCriteria(Search $search)
    {
        $queryBuilder = $this->createQueryBuilder('u');

        // Ajoutez des clauses WHERE en fonction des critères de recherche
        if ($search->getSport()) {
            $queryBuilder->andWhere('u.sportPratique = :sport')
                         ->setParameter('sport', $search->getSport());
        }

        if ($search->getNiveau()) {
            $queryBuilder->andWhere('u.niveau = :niveau')
                         ->setParameter('niveau', $search->getNiveau());
        }

        if ($search->getDepartement()) {
            $queryBuilder->andWhere('u.departement = :departement')
                         ->setParameter('departement', $search->getDepartement());
        }

        // Exécutez la requête
        return $queryBuilder->getQuery()->getResult();
    }
}
