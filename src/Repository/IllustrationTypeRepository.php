<?php

namespace App\Repository;

use App\Entity\IllustrationType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IllustrationType|null find($id, $lockMode = null, $lockVersion = null)
 * @method IllustrationType|null findOneBy(array $criteria, array $orderBy = null)
 * @method IllustrationType[]    findAll()
 * @method IllustrationType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IllustrationTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IllustrationType::class);
    }

    // /**
    //  * @return IllustrationType[] Returns an array of IllustrationType objects
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
    public function findOneBySomeField($value): ?IllustrationType
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
