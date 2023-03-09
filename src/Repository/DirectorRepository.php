<?php

namespace App\Repository;

use App\Entity\Director;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Director>
 *
 * @method Director|null find($id, $lockMode = null, $lockVersion = null)
 * @method Director|null findOneBy(array $criteria, array $orderBy = null)
 * @method Director[]    findAll()
 * @method Director[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DirectorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Director::class);
    }

    public function add(Director $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Director $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * method return Director[] Returns an array of Director objects where id = value and label = "firstname lastname"
     *
     * @return array
     */
    public function findAllForForm($needle): array
    {
        return $this->createQueryBuilder('d')
            ->orderBy('d.lastname')
            ->where('d.lastname LIKE :needle')
            ->setParameter('needle', '%'. $needle.'%')
            ->select('d.id as value', "(concat(concat(d.firstname,' '), d.lastname)) as label")
            ->getQuery()
            ->getResult()
        ;
    }

    public function searchByName($query)
    {
        return $this->createQueryBuilder('d')
        ->orderBy('d.lastname')
        ->where('CONCAT(d.firstname, \' \', d.lastname) LIKE :query')
        ->setParameter('query', '%'. $query.'%')
        ->getQuery()
        ->getResult()
        ;
    }   
       
//    /**
//     * @return Director[] Returns an array of Director objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Director
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
