<?php

namespace App\Repository;

use App\Entity\Souscollectioncnd;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Souscollectioncnd|null find($id, $lockMode = null, $lockVersion = null)
 * @method Souscollectioncnd|null findOneBy(array $criteria, array $orderBy = null)
 * @method Souscollectioncnd[]    findAll()
 * @method Souscollectioncnd[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SouscollectioncndRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Souscollectioncnd::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Souscollectioncnd $entity, bool $flush = true): void
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
    public function remove(Souscollectioncnd $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Souscollectioncnd[] Returns an array of Souscollectioncnd objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Souscollectioncnd
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
