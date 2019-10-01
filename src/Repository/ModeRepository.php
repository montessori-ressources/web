<?php

namespace App\Repository;

use App\Entity\Mode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Mode|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mode|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mode[]    findAll()
 * @method Mode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Mode::class);
    }

    // /**
    //  * @return Mode[] Returns an array of Mode objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Mode
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
