<?php

namespace App\Repository;

use App\Entity\Collectioncnd;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Collectioncnd|null find($id, $lockMode = null, $lockVersion = null)
 * @method Collectioncnd|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collectioncnd[]    findAll()
 * @method Collectioncnd[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollectioncndRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Collectioncnd::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Collectioncnd $entity, bool $flush = true): void
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
    public function remove(Collectioncnd $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Collectioncnd[] Returns an array of Resource objects
     */
    
    public function findFolderFront(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.folderFront = true')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return CollectioncndComplete[] Returns an array of Resource objects
     */
    
    public function findCollections(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.published = 1')
            ->andWhere('c.id != 7')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return AllCollectioncndComplete[] Returns an array of Resource objects
     */
    
    public function findAllCollections(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.published = 1')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Collectioncnd[] Returns an array of Collectioncnd objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Collectioncnd
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
