<?php

namespace App\Repository;

use App\Entity\Association;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Association|null find($id, $lockMode = null, $lockVersion = null)
 * @method Association|null findOneBy(array $criteria, array $orderBy = null)
 * @method Association[]    findAll()
 * @method Association[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssociationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Association::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Association $entity, bool $flush = true): void
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
    public function remove(Association $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findByFilters($terme, $paramCat1, $paramCat2, $paramCat3, $paramCat4, $paramCat5, $paramCat6, $paramCat7)
    {
        $terme = strtoupper($terme);
        dump($terme);
        $qb = $this->createQueryBuilder('a');

        if( $paramCat1 != null  ) {
            $qb->orWhere('a.categorie = :paramCat1')
                ->setParameter('paramCat1', $paramCat1);
        }
        if( $paramCat2 != null  ) {
            $qb->orWhere('a.categorie = :paramCat2')
                ->setParameter('paramCat2', $paramCat2);
        }
        if( $paramCat3 != null  ) {
            $qb->orWhere('a.categorie = :paramCat3')
                ->setParameter('paramCat3', $paramCat3);
        }
        if( $paramCat4 != null  ) {
            $qb->orWhere('a.categorie = :paramCat4')
                ->setParameter('paramCat4', $paramCat4);
        }
        if( $paramCat5 != null  ) {
            $qb->orWhere('a.categorie = :paramCat5')
                ->setParameter('paramCat5', $paramCat5);
        }
        if( $paramCat6 != null  ) {
            $qb->orWhere('a.categorie = :paramCat6')
                ->setParameter('paramCat6', $paramCat6);
        }
        if( $paramCat7 != null  ) {
            $qb->orWhere('a.categorie = :paramCat7')
                ->setParameter('paramCat7', $paramCat7);
        }
        if( $terme != null  ) {
            $qb->andWhere('a.nom LIKE :termeSearch')
                ->setParameter('termeSearch', $terme . '%');
        }

        $query = $qb->getQuery();
        return $query->getResult();
    }

//    public function findOneBySomeField($value): ?Association
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}
