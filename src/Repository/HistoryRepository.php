<?php

namespace App\Repository;

use App\Entity\History;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method History|null find($id, $lockMode = null, $lockVersion = null)
 * @method History|null findOneBy(array $criteria, array $orderBy = null)
 * @method History[]    findAll()
 * @method History[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, History::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(History $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(History $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return array
     */
    public function findPlaces()
    {
        return array_column(
            $this
                ->createQueryBuilder('entity')
                ->select('entity.place')
                ->distinct(true)->getQuery()
                ->getArrayResult(),
            'place'
        );
    }

    function findData($params){
        $builder = $this->createQueryBuilder('entity');

        if($place = $params['place'] ?? null){
            $builder
                ->andWhere('entity.place = :place')
                ->setParameter('place', $place);
        }

        if($from = $params['from'] ?? null){
            $builder
                ->andWhere('entity.exportDate >= :from')
                ->setParameter('from', $from);
        }

        if($from = $params['to'] ?? null){
            $builder
                ->andWhere('entity.exportDate <= :to')
                ->setParameter('to', $from->modify('+1 days'));
        }

        return $builder
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return History[] Returns an array of History objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?History
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
