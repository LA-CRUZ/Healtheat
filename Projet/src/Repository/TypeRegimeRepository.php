<?php

namespace App\Repository;

use App\Entity\TypeRegime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeRegime|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeRegime|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeRegime[]    findAll()
 * @method TypeRegime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeRegimeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypeRegime::class);
    }

    // /**
    //  * @return TypeRegime[] Returns an array of TypeRegime objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeRegime
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
