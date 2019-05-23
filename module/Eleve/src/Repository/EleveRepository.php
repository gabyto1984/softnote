<?php
namespace Eleve\Repository;
use Doctrine\ORM\EntityRepository;
use Eleve\Entity\Eleve;
use Doctrine\ORM\Query;
/**
 * This is the custom repository class for eleve entity.
 */
class EleveRepository extends EntityRepository
{
    
    /**
     * Finds all students.
     * @return array
     */
    
     public function findAllEleves()
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('e')
            ->from(Eleve::class, 'e')
            ->orderBy('e.date_naissance', 'DESC');
        
        return $queryBuilder->getQuery();
    }
    
     public function findAllElevesClasse($classe)
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('e')
            ->from(Eleve::class, 'e')
            ->join('e.classeeleve', 'ce')
            ->where('ce.classe = ?1')
            ->orderBy('e.nom_eleve', 'DESC')
            ->setParameter('1', $classe);
        
        return $queryBuilder->getQuery()->getResult();
    }  
    
    public function findAllElevesNotesClasse($classe, $periode){
        
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('e')
            ->from(Eleve::class, 'e')
            ->join('e.classeeleve', 'ce')
            ->join('e.evaluations', 'ee')
            ->where('ce.classe = ?1')
            ->andWhere('ee.periodeval = ?2')
            ->orderBy('e.nom_eleve', 'DESC')
            ->setParameter('1', $classe)
            ->setParameter('2', $periode);
        
        return $queryBuilder->getQuery()->getResult();
    }
       
   
}

