<?php

namespace App\Repository;

use App\Entity\TempsEffortPhy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TempsEffortPhy|null find($id, $lockMode = null, $lockVersion = null)
 * @method TempsEffortPhy|null findOneBy(array $criteria, array $orderBy = null)
 * @method TempsEffortPhy[]    findAll()
 * @method TempsEffortPhy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TempsEffortPhyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TempsEffortPhy::class);
    }

    // /**
    //  * @return TempsEffortPhy[] Returns an array of TempsEffortPhy objects
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
    public function findOneBySomeField($value): ?TempsEffortPhy
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
