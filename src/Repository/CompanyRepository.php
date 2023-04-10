<?php

namespace App\Repository;

use App\Entity\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Company>
 *
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    public function save(Company $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Company $entity, bool $flush = false): void
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
        ->from('App\Entity\Company', 'u')
        ->leftJoin('u.activities', 'a')
        ->where($qb->expr()->orX(
            $qb->expr()->like('u.username', ':searchString'),
            $qb->expr()->like('u.mail', ':searchString'),
            $qb->expr()->like('u.telephone', ':searchString'),
            $qb->expr()->like('a.label', ':searchString')
        ))
        ->setParameter('searchString', '%'.$searchString.'%');

        $result = array_chunk($qb->getQuery()->getResult(), $pageLimit, true);

        return isset($result[$page ?: 0]) ? $result[$page ?: 0] : $result;
    }

//    /**
//     * @return Company[] Returns an array of Company objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Company
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function getAllCompanies(): array 
    {
        return $this->findAll();
    }

}
