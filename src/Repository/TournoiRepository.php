<?php

namespace App\Repository;

use App\Entity\Tournoi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tournoi>
 */
class TournoiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tournoi::class);
    }

    //    /**
    //     * @return Tournoi[] Returns an array of Tournoi objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Tournoi
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    /**
     * @return array<int, array<string, mixed>>
     */

     public function findAllAfterThanDataSQL($datemax): array
     {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT t.id, t.libelle, t.date, t.categorie_id, ct.libelle as categorie_libelle
            FROM tournoi t
            LEFT JOIN cat_tournois ct ON t.categorie_id = ct.id
            WHERE t.date > :datemax
            ORDER BY t.date ASC';
        $stmt = $conn->prepare($sql);
        $resultat = $stmt->executeQuery(['datemax' => $datemax]);

        return $resultat->fetchAllAssociative();
     }

    /**
     * @return Tournoi[]
     */
    public function findAllAfterThanDateDQL($datemax): array
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.categorie', 'c')
            ->addSelect('c')
            ->where('t.date > :datemax')
            ->setParameter('datemax', $datemax)
            ->orderBy('t.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Tournoi[]
     */
    public function findAllAfterThanDateQB($datemax): array
    {
        $qb = $this->createQueryBuilder('t');
        
        $qb->leftJoin('t.categorie', 'c')
           ->addSelect('c')
           ->where($qb->expr()->gt('t.date', ':datemax'))
           ->setParameter('datemax', $datemax)
           ->orderBy('t.date', 'ASC');
        
        return $qb->getQuery()->getResult();
    }
}
