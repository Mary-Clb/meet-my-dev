<?php

namespace App\Repository;

use App\Entity\Developer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\Collection;

/**
 * @extends ServiceEntityRepository<Developer>
 *
 * @method Developer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Developer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Developer[]    findAll()
 * @method Developer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeveloperRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Developer::class);
    }

    public function save(Developer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Developer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByString(string $searchString, $page = 0, $pageLimit = 10): array
    {
        $qb = $this->getEntityManager()->createQUeryBuilder();

        $qb->select('u')
        ->from('App\Entity\Developer', 'u')
        ->leftJoin('u.specialities', 'l')
        ->where($qb->expr()->orX(
            $qb->expr()->like('u.username', ':searchString'),
            $qb->expr()->like('u.presentation', ':searchString'),
            $qb->expr()->like('l.label', ':searchString')
        ))
        ->setParameter('searchString', '%'.$searchString.'%');

        $result = array_chunk($qb->getQuery()->getResult(), $pageLimit, true);

        return isset($result[$page ?: 0]) ? $result[$page ?: 0] : $result;
    }

//    /**
//     * @return Developer[] Returns an array of Developer objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Developer
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
