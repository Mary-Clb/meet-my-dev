<?php

namespace App\Repository;

use App\Entity\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\InputBag;

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

    public function findByString(InputBag $input, $page = 0, $pageLimit = 10): array
    {
        $searchString = $input->get('search');

        $qb = $this->getEntityManager()->createQUeryBuilder();

        $qb->select('u')
        ->from('App\Entity\Company', 'u')
        ->leftJoin('u.activities', 'a');
        $orX = $qb->expr()->orX();
        $hasCondition = false;

        if ($input->get('name')) {
            $orX->add($qb->expr()->like('u.username', ':searchString'));
            $hasCondition = true;
        }

        if ($input->get('presentation')) {
            $orX->add($qb->expr()->like('u.presentation', ':searchString'));
            $hasCondition = true;
        }

        if ($input->get('activities')) {
            $orX->add($qb->expr()->like('a.label', ':searchString'));
            $hasCondition = true;
        }

        if ($hasCondition) {
            $qb->andWhere($orX)
            ->setParameter('searchString', '%'.$searchString.'%');
        }

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
