<?php

namespace App\Repository;

use App\Entity\DownloadOptions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DownloadOptions|null find($id, $lockMode = null, $lockVersion = null)
 * @method DownloadOptions|null findOneBy(array $criteria, array $orderBy = null)
 * @method DownloadOptions[]    findAll()
 * @method DownloadOptions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DownloadOptionsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DownloadOptions::class);
    }

    // /**
    //  * @return DownloadOptions[] Returns an array of DownloadOptions objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DownloadOptions
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
