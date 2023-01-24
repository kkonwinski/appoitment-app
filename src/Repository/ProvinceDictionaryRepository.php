<?php

namespace App\Repository;

use App\Entity\ProvinceDictionary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProvinceDictionary>
 *
 * @method ProvinceDictionary|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProvinceDictionary|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProvinceDictionary[]    findAll()
 * @method ProvinceDictionary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProvinceDictionaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProvinceDictionary::class);
    }

    public function save(ProvinceDictionary $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProvinceDictionary $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ProvinceDictionary[] Returns an array of ProvinceDictionary objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProvinceDictionary
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
