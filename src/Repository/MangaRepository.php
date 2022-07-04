<?php

namespace App\Repository;

use App\Entity\Manga;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Manga>
 *
 * @method Manga|null find($id, $lockMode = null, $lockVersion = null)
 * @method Manga|null findOneBy(array $criteria, array $orderBy = null)
 * @method Manga[]    findAll()
 * @method Manga[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MangaRepository extends ServiceEntityRepository
{
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Manga::class);
    }

    public function add(Manga $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Manga $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Manga[] Returns an array of Manga objects
//     */
        
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Manga
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
   /**
    * @return Manga[] Returns an array of Manga objects
    */
        
   public function findManga(): array
   {
       return $this->createQueryBuilder('m')

           ->orderBy('m.Titre', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }
    // /**
    // * @return Manga[] Returns an array of Manga objects
    // */
        
    // public function findNote($note)
    // {
    //     $em = $this->getEntityManager();
    //     $sub = $em->createQueryBuilder();

    //     $qb = $sub;
    //     $qb->select('m')
    //         ->from('App\Entity\Manga', 'm')
    //         ->leftJoin('m.userMangas', 'mu')
    //         ->where('mu.id = :id');

    //     $sub = $em->createQueryBuilder();
    //     $sub->select('st')
    //         ->from('App\Entity\Manga', 'st')
    //         ->where($sub->expr()->notIn('st.id', $qb->getDQL()))
    //         ->setParameter('id', $note)
    //         ->orderBy('st.totalNote');

    //     $query = $sub->getQuery();
    //     return $query->getResult();
    // }
}
