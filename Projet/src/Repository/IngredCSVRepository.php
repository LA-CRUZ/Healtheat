<?php

namespace App\Repository;

use App\Entity\IngredCSV;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IngredCSV|null find($id, $lockMode = null, $lockVersion = null)
 * @method IngredCSV|null findOneBy(array $criteria, array $orderBy = null)
 * @method IngredCSV[]    findAll()
 * @method IngredCSV[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredCSVRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IngredCSV::class);
    }

    // /**
    //  * @return IngredCSV[] Returns an array of IngredCSV objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IngredCSV
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
