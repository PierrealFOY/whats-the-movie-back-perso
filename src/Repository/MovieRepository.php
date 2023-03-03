<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Movie>
 *
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    public function add(Movie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Movie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Return Movie[] Returns an array of limit Movies objects
     *
     * @param integer $limit
     * @return array
     */
    public function findRandomMoviesGame(int $limit): array
    {
        return $this->createQueryBuilder('m')
            ->orderBy('RAND()')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findSearch(SearchData $search)
    {
        $query = $this
            ->createQueryBuilder('m');

        if ($search->actif && $search->inactif) {

            return $query->getQuery()->getResult();
        }
        if ($search->inactif) {
            $query = $query
                ->andWhere('m.status = 0');
        }
        if ($search->actif) {
            $query = $query
                ->andWhere('m.status = 1');
        }


        return $query->getQuery()->getResult();
        
    }   

    public function searchByTitle($query)
    {
        $data = $this->createQueryBuilder('m')
        ->where('m.title LIKE :query')
        ->setParameter('query', '%'. $query.'%')
        ->orderBy('m.title');

        return $data->getQuery()->getResult();
    }

//    /**
//     * @return Movie[] Returns an array of Movie objects
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

//    public function findOneBySomeField($value): ?Movie
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
