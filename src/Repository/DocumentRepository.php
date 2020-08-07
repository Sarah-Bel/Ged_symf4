<?php

namespace App\Repository;

use App\Entity\Document;
use App\Entity\TypeDocument;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\AST\Join;
use Doctrine\ORM\Query\Expr\Join as ExprJoin;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Document|null find($id, $lockMode = null, $lockVersion = null)
 * @method Document|null findOneBy(array $criteria, array $orderBy = null)
 * @method Document[]    findAll()
 * @method Document[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
        
    }

    public function findTotatldoc()
    {
        return $this->createQueryBuilder('d')
            ->select('count(d.id) as total ')
            ->getQuery()
            ->getResult()
        ; 
    }

    public function findDocJrs(\Datetime $date)
    {
     
        $from = new \DateTime($date->format("Y-m-d")." 00:00:00");
        $to   = new \DateTime($date->format("Y-m-d")." 23:59:59");
    
        return $this->createQueryBuilder('d')
            ->select('count(d.id) as totalparjrs ')
            ->andWhere('d.CreatedAt BETWEEN :from AND :to')
            ->setParameter('from', $from )
            ->setParameter('to', $to)
            ->getQuery()
            ->getResult()
        ;
       
        
    }

    public function findDocTypeFacture()
    {
     
        return $this->createQueryBuilder('d')
            
                ->select('count(d.nomdocument) as Facture')
                ->innerjoin (TypeDocument::class,'t', ExprJoin::WITH,'t.id=d.nomdocument')
                ->andWhere('d.nomdocument = 8')
                ->getQuery()
                ->getResult()
                  
        ;        
        
    }

    public function findDocTypePV()
    {
     
        return $this->createQueryBuilder('d')
            
                ->select('count(d.nomdocument) as PV')
                ->innerjoin (TypeDocument::class,'t', ExprJoin::WITH,'t.id=d.nomdocument')
                ->andWhere('d.nomdocument = 9')
                ->getQuery()
                ->getResult()
                  
        ;        
        
    }

    public function findDocTypeRC()
    {
     
        return $this->createQueryBuilder('d')
            
                ->select('count(d.nomdocument) as RC')
                ->innerjoin (TypeDocument::class,'t', ExprJoin::WITH,'t.id=d.nomdocument')
                ->andWhere('d.nomdocument = 10')
                ->getQuery()
                ->getResult()
                  
        ;        
        
    }

    public function findDocTypeEtude()
    {
     
        return $this->createQueryBuilder('d')
            
                ->select('count(d.nomdocument) as Etude')
                ->innerjoin (TypeDocument::class,'t', ExprJoin::WITH,'t.id=d.nomdocument')
                ->andWhere('d.nomdocument = 11')
                ->getQuery()
                ->getResult()
                  
        ;        
        
    }

    public function findDocparMois()
    {
    
        $date = new \DateTime();
        
        return $this->createQueryBuilder('d')
        
                ->select('count(d.nomdocument) as totalparmois')
                ->andWhere('MONTH(d.CreatedAt) = :date')
                ->setParameter('date', $date->format('m') )
                ->getQuery()
                ->getResult()
               
        ;        
        
    }


    public function findDocparAnnees()
    {
    
        $date = new \DateTime();
        
        return $this->createQueryBuilder('d')
        
                ->select('count(d.nomdocument) as totalparannees')
                ->andWhere('YEAR(d.CreatedAt) = :date')
                ->setParameter('date', $date->format('Y') )
                ->getQuery()
                ->getResult()
               
        ;        
        
    }




    // /**
    //  * @return Document[] Returns an array of Document objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Document
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

     
  
    
}
