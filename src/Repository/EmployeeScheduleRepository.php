<?php

namespace App\Repository;

use App\Entity\EmployeeSchedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EmployeeSchedule>
 *
 * @method EmployeeSchedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployeeSchedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployeeSchedule[]    findAll()
 * @method EmployeeSchedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeScheduleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmployeeSchedule::class);
    }

    public function save(EmployeeSchedule $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EmployeeSchedule $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
//find all employee schedules by company by user
    public function findEmployeeSchedulesByCompany($company)
    {
        return $this->createQueryBuilder('es')
       // ->leftJoin('e.user', 'u')
       // ->leftJoin('u.company', 'c')
        //->where('c = :company')
        //->andWhere('u.roles = :role')
      //  ->setParameter('company', $company)
       // ->setParameter('role', "ROLE_EMPLOYEE")
        ->getQuery()
        ->getResult();
    }

//    /**
//     * @return EmployeeSchedule[] Returns an array of EmployeeSchedule objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EmployeeSchedule
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
