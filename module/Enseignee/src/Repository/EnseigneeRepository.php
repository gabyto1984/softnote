<?php
namespace Enseignee\Repository;
use Doctrine\ORM\EntityRepository;
use Enseignee\Entity\Enseignee;
use Classe\Entity\Classe;
use Matiere\Entity\Matiere;
use Doctrine\ORM\Query;
/**
 * This is the custom repository class for Enseignee entity.
 */
class EnseigneeRepository extends EntityRepository
{
    
    /**
     * Finds all published posts having any tag.
     * @return array
     */
    public function findAllEnseignees()
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('c')
            ->from(Matiere::class, 'c')
            ->orderBy('c.libele_matiere', 'DESC');
        
        return $queryBuilder->getQuery();
    }
    
    public function findAllMatiereClasse($classe, $periode)
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('e')
            ->from(Enseignee::class, 'e')
            ->join('e.matiere', 'ee')
            ->where('e.classe = ?1')
            ->andWhere('e.periodeval = ?2')
            ->orderBy('e.coefficient', 'DESC')
            ->setParameter('1', $classe)
            ->setParameter('2', $periode);
        
        return $queryBuilder->getQuery()->getResult();
    } 
    
    public function findAllMatiereCoef($classe){
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('e')
            ->from(Enseignee::class, 'e')
            ->join('e.matiere', 'ee')
            ->where('e.classe = ?1')
            ->orderBy('e.coefficient', 'DESC')
            ->setParameter('1', $classe);
        
        return $queryBuilder->getQuery()->getResult();
    }
       
}

