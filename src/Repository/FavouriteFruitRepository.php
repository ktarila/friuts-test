<?php

/*
 * Frutits Test App.
 * (c) Patrick <ktarila@gmail.com>.
 */

namespace App\Repository;

use App\Entity\FavouriteFruit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FavouriteFruit>
 *
 * @method FavouriteFruit|null find($id, $lockMode = null, $lockVersion = null)
 * @method FavouriteFruit|null findOneBy(array $criteria, array $orderBy = null)
 * @method FavouriteFruit[]    findAll()
 * @method FavouriteFruit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavouriteFruitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FavouriteFruit::class);
    }

    public function save(FavouriteFruit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FavouriteFruit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOldest(): ?FavouriteFruit
    {
        return $this->createQueryBuilder('f')
           ->orderBy('f.id', 'ASC')
           ->setMaxResults(1)
           ->getQuery()
           ->getOneOrNullResult()
        ;
    }

    public function countFavoriteFruits()
    {
        return $this->createQueryBuilder('f')
           ->select('COUNT(f.id) as numFavorite')
           ->getQuery()
           ->getSingleScalarResult()
        ;
    }
}
