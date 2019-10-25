<?php
namespace Salle\Repository;
use Doctrine\ORM\EntityRepository;
use Salle\Entity\Salle;
use Doctrine\ORM\Query;
/**
 * This is the custom repository class for Salle entity.
 */
class SalleRepository extends EntityRepository
{
    
    /**
     * Finds all published posts having any tag.
     * @return array
     */
    public function findAllSalles()
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('c')
            ->from(Salle::class, 'c')
            ->orderBy('c.libele', 'DESC');
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    public function findBySalle($classe){
       $entityManager = $this->getEntityManager();
        
       $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('m')
            ->from(Salle::class, 'm')
            ->join('m.classe', 'mc')
            ->join('mc.matiereaffectees', 'mcm')
            ->where('m.classe = ?1')
            ->setParameter('1', $classe);
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    public function findAllSalleNotConfig()
    {
       $entityManager = $this->getEntityManager();        
       $qb  = $entityManager->createQueryBuilder();
       $qb2 = $qb;
       $qb2->select('m.id')
           ->from('Classe\Entity\Classe', 'ms')
           ->Join('ms.salles', 'm');

       $qb  = $entityManager->createQueryBuilder();
       $qb->select('mm')
           ->from('Salle\Entity\Salle', 'mm')
           ->where($qb->expr()->notIn('mm.id', $qb2->getDQL())
         );
        
        $query  = $qb->getQuery();

       return $query->getResult();
       
    }
    
    
}

