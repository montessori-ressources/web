<?php

namespace App\Repository;

use App\Entity\ImageCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ImageCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageCategory[]    findAll()
 * @method ImageCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ImageCategory::class);
    }

    // /**
    //  * @return ImageCategory[] Returns an array of ImageCategory objects
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
    public function findOneBySomeField($value): ?ImageCategory
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
