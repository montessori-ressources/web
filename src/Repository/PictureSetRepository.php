<?php

namespace App\Repository;

use App\Entity\PictureSet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PictureSet|null find($id, $lockMode = null, $lockVersion = null)
 * @method PictureSet|null findOneBy(array $criteria, array $orderBy = null)
 * @method PictureSet[]    findAll()
 * @method PictureSet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictureSetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PictureSet::class);
    }

    // /**
    //  * @return PictureSet[] Returns an array of PictureSet objects
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
    public function findOneBySomeField($value): ?PictureSet
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
