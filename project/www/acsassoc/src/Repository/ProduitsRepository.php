<?php

namespace App\Repository;

use App\Entity\Produits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\ClassMain\ConfigSite;

/**
 * @extends ServiceEntityRepository<Produits>
 *
 * @method Produits|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produits|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produits[]    findAll()
 * @method Produits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produits::class);
    }

    public function add(Produits $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Produits $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function end_garantee() {

        $query = $this->createQueryBuilder('p');
        $query->innerJoin('p.users', 'u');
        $query->where('p.guarantee_at = :now');
        $query->setParameter('now', date("Y-m-d"));
        return $query->getQuery()
            ->getResult()
        ;
    }

    public function before_end_garantee() {

        $config = new ConfigSite();
        $query = $this->createQueryBuilder('p');
        $query->innerJoin('p.users', 'u');
        $query->where('p.guarantee_at = :now');
        $query->setParameter('now', date("Y-m-d", strtotime(date("Y-m-d"). ' + '.$config->getNb_jour().' days')));
        return $query->getQuery()
            ->getResult()
        ;
    }

    /**
     * Undocumented function
     *
     * @param [type] $mots
     * @return Produits[] Returns an array of Produits objects
     */
    public function search($mots = null, $categorie = null): array {
        $query = $this->createQueryBuilder('p');
        $query->innerJoin('p.categories', 'c');
        $query->where('p.active = 1');
        if($mots != null) {
            $query->andWhere('MATCH_AGAINST(p.name, p.content) AGAINST (:mots boolean) > 0 OR MATCH_AGAINST(c.name) AGAINST (:mots boolean) > 0')
                ->setParameter('mots', $mots);
        }
        if($categorie != null) {
            $query->andWhere('c.id = :id')
                ->setParameter('id', $categorie);
        }
        return $query->getQuery()->getResult();
    }

    /**
     * Returns number of "Produits" per day
     * @return void 
     */
    public function countByDate($from = null, $to = null){
        $query = $this->createQueryBuilder('p');
        $query
            ->select('SUBSTRING(p.achat_at, 1, 10) as dateProduits, COUNT(p) as count, c.name as categorie_name, c.color as color')
            ->innerJoin('p.categories', 'c');
        if(!empty($from)) {
            $query->andWhere('p.achat_at > :from')
                ->setParameter(':from', $from);
        }
        if(!empty($to)) {
            $query->andWhere('p.achat_at < :to')
                ->setParameter(':to', $to);
        }
        $query->groupBy('dateProduits')//, categorie_name
            ->orderBy('c.name', 'ASC')
        ;
        return $query->getQuery()->getResult();
    }

    /**
     * Returns number of "Produits" per day
     * @return void 
     */
    public function countPriceByDate($from = null, $to = null){
        $query = $this->createQueryBuilder('p');
        $query
            ->select('SUBSTRING(p.achat_at, 1, 10) as dateProduits, SUM(p.price) as count, c.name as categorie_name, c.color as color')
            ->innerJoin('p.categories', 'c');
        if(!empty($from)) {
            $query->andWhere('p.achat_at > :from')
                ->setParameter(':from', $from);
        }
        if(!empty($to)) {
            $query->andWhere('p.achat_at < :to')
                ->setParameter(':to', $to);
        }
        $query->groupBy('dateProduits')//, categorie_name
            ->orderBy('c.name', 'ASC')
        ;
       return $query->getQuery()->getResult();
   }

//    /**
//     * @return Produits[] Returns an array of Produits objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.name = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Produits
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
