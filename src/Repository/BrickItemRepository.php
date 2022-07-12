<?php

namespace App\Repository;

use App\Entity\BrickItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BrickItem>
 *
 * @method BrickItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method BrickItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method BrickItem[]    findAll()
 * @method BrickItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrickItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BrickItem::class);
    }

    public function add(BrickItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BrickItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    public function findAllFromIdList($idList): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.no in (:val)')
            ->setParameter('val', $idList)
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return BrickItem[] Returns an array of BrickItem objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BrickItem
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
