<?php

namespace App\Repository;

use App\Entity\CompanyAddressAdditionalInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompanyAddressAdditionalInfo>
 *
 * @method CompanyAddressAdditionalInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyAddressAdditionalInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyAddressAdditionalInfo[]    findAll()
 * @method CompanyAddressAdditionalInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyAddressAddiotionalInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyAddressAdditionalInfo::class);
    }

    public function save(CompanyAddressAdditionalInfo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CompanyAddressAdditionalInfo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CompanyAddressAddiotionalInfo[] Returns an array of CompanyAddressAddiotionalInfo objects
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

//    public function findOneBySomeField($value): ?CompanyAddressAddiotionalInfo
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
