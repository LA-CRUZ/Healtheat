<?php

namespace App\Repository;

use App\Entity\ProgContenu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProgContenu|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProgContenu|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProgContenu[]    findAll()
 * @method ProgContenu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgContenuRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProgContenu::class);
    }

    // /**
    //  * @return ProgContenu[] Returns an array of ProgContenu objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProgContenu
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
