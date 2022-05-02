<?php

namespace App\Repository;

use App\Entity\Subvention;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Subvention|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subvention|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subvention[]    findAll()
 * @method Subvention[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubventionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subvention::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Subvention $entity, bool $flush = true): void
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
    public function remove(Subvention $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findByFiltersSubvention($paramAssociationSelect, $paramEtatSubventionSelect, $paramSubFonctionnements,
                                            $paramSubEquipements, $paramSubExceptionnelles, $paramSubNatures, $choixDateStart, $choixDateEnd)
    {
        if($paramSubNatures != null) {
            $qb = $this->createQueryBuilder('s')
                ->addSelect('t')
                ->innerJoin('s.typeSubvention', 't')
                ->where('t.categorie = :paramSubNatures')
                ->setParameter('paramSubNatures', $paramSubNatures);
        }else {
            $qb = $this->createQueryBuilder('s');
        }

        if($paramSubFonctionnements != null) {
            $qb->orWhere('s.typeSubvention = :paramSubFonctionnements')
                ->setParameter('paramSubFonctionnements', $paramSubFonctionnements);
        }
        if($paramSubEquipements != null) {
            $qb->orWhere('s.typeSubvention = :paramSubEquipements')
                ->setParameter('paramSubEquipements', $paramSubEquipements );
        }
        if($paramSubExceptionnelles != null) {
            $qb->orWhere('s.typeSubvention = :paramSubExceptionnelles')
                ->setParameter('paramSubExceptionnelles', $paramSubExceptionnelles);
        }



        if($paramAssociationSelect != null) {
            $qb->andWhere('s.association = :paramAssociationSelect')
                ->setParameter('paramAssociationSelect', $paramAssociationSelect);
        }
        if($paramEtatSubventionSelect != null) {
            $qb->andWhere('s.etat = :paramEtatSubventionSelect')
                ->setParameter('paramEtatSubventionSelect', $paramEtatSubventionSelect);
        }
        if ($choixDateStart != null) {
            $qb->andWhere('s.dateDemande >= :choixDateStart')
                ->setParameter('choixDateStart', $choixDateStart);
        }
        if ($choixDateEnd != null) {
            $qb->andWhere('s.dateDemande <= :choixDateEnd')
                ->setParameter('choixDateEnd', $choixDateEnd);
        }

        $query = $qb->getQuery();
        return $query->getResult();
    }



    // /**
    //  * @return Subvention[] Returns an array of Subvention objects
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
    public function findOneBySomeField($value): ?Subvention
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
