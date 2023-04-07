<?php

namespace App\Repository;

use App\Entity\Ressource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use App\Classe\Search;

/**
 * @method Ressource|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ressource|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ressource[]    findAll()
 * @method Ressource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RessourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ressource::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Ressource $entity, bool $flush = true): void
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
    public function remove(Ressource $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function compteByIdcadic($idcadic)
    {
        return $this->createQueryBuilder('r')
        ->select('COUNT(r.id)')
        ->Where('r.referenceCadic like :id')
        ->setParameter('id', $idcadic)
        ->getQuery()
        ->getSingleScalarResult()
        ;
    }
     
    public function findByIdcadic($idcadic)
    {
        return $this->createQueryBuilder('r')
        ->select()
        ->Where('r.referenceCadic = :val')
        ->setParameter('val', $idcadic)
        ->getQuery()
        ->getResult()
        //->getOneOrNullResult()
        ;
    }

    public function findByDocRef($idcadic)
    {
        return $this->createQueryBuilder('r')
        ->select()
        ->Where('r.referenceCadic = :val')
        ->setParameter('val', $idcadic)
        ->getQuery()
        //->getResult()
        ->getOneOrNullResult()
        ;
    }

    /**
     * requete qui permet de récupérer les ressources en fonction de la recherche des utilisateurs
     * On récupère la classe Search et on stocke dans la variable $search
     * @return Ressource[];
     */
    public function findWithSearch(Search $search)
    {
        $query = $this
            ->createQueryBuilder('r')
         ;

        if(!empty($search->string)){
            
            $string = $search->string;
            $string = preg_replace('/[^A-Za-z0-9\-]/', '%', $string);
            $string = preg_replace('" +"', '%', $string);
            $string = '%'.$string.'%';
            
            $query = $query
                ->andWhere('r.titre LIKE :string')
                ->orWhere('r.personne LIKE :string')
                ->orWhere('r.oeuvre LIKE :string')
                ->orWhere('r.organisme LIKE :string')
                ->orWhere('r.referenceCadic LIKE :string')
                ->orWhere('r.type LIKE :string')
                ->orWhere('r.auteur LIKE :string')
                ->setParameter('string', $string)
        ;
        return $query->getQuery()->getResult();
        }
    }

    public function findWithSearchExpression($search)
    {
        $query = $this
            ->createQueryBuilder('r')
         ;

        if(!empty($search)){
            
            $string = $search;
            $string = preg_replace('/[^A-Za-z0-9\-]/', '%', $string);
            $string = preg_replace('" +"', '%', $string);
            $string = '%'.$string.'%';
            
            $query = $query
                ->andWhere('r.titre LIKE :string')
                ->orWhere('r.personne LIKE :string')
                ->orWhere('r.oeuvre LIKE :string')
                ->orWhere('r.organisme LIKE :string')
                ->orWhere('r.referenceCadic LIKE :string')
                ->orWhere('r.type LIKE :string')
                ->orWhere('r.auteur LIKE :string')
                ->setParameter('string', $string)
        ;
        return $query->getQuery()->getResult();
        }
    }

    /**
     * @return Resource[] Returns an array of Resource objects
     */
    
    public function findFolderFront(): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.folderFront = true')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Resource[] Returns an array of Resource objects
     */
    
    public function findAllFront(): array
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    // /**
    //  * @return Ressource[] Returns an array of Ressource objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ressource
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
