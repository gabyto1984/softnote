<?php
namespace Classe\Repository;
use Doctrine\ORM\EntityRepository;
use Classe\Entity\Classe;
use Matiere\Entity\Matiere;
use Matiere\Entity\MatiereAffectee;
use Eleve\Entity\Eleve;
use Salle\Entity\Salle;
use Evaluation\Entity\Evaluation;
use Doctrine\ORM\Query;
/**
 * This is the custom repository class for Classe entity.
 */
class ClasseRepository extends EntityRepository
{
    
    /**
     * Finds all published posts having any tag.
     * @return array
     */
    public function findAllClasses()
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('c')
            ->from(Classe::class, 'c')
            ->orderBy('c.id', 'DESC');
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    
    //findAllClassesHavingMatiere()
    public function findAllClassesHavingMatiere()
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('c')
            ->from(Classe::class, 'c')
            ->Join('c.matiereaffectees', 'cm')
            ->orderBy('cm.coefficient', 'DESC');
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    public  function findByClasse($classe){
       $entityManager = $this->getEntityManager();
        
       $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('m')
            ->from(Classe::class, 'm')
            ->Join('m.matiereaffectees', 'mm')
            ->where('mm.classe = ?1')
            ->setParameter('1', $classe);
        
        return $queryBuilder->getQuery()->getResult();
  
    }
    
    public function findAllEleveNonEvalue($classe, $periodeval, $matiere)
    {
       $entityManager = $this->getEntityManager();        
       $qb  = $entityManager->createQueryBuilder();
       $qb2 = $qb;
      
       $qb2->select('mme.id')
           ->from(Evaluation::class, 'mm')
           ->join('mm.eleve_inscrit', 'mme')   
           ->join('mm.periodeval', 'mmp')
           ->join('mm.matiere_affectee', 'mmea')
           ->join('mmea.matiere', 'mmeam')    
           ->join('mmea.classe', 'mc')
           ->where('mc.id = ?1')
           ->andWhere('mmp.id = ?2')
           ->andWhere('mmeam.id = ?3');
       
       $qb  = $entityManager->createQueryBuilder();
       $qb->select('cc')
           ->from('Classe\Entity\ClasseEleves', 'cc')
           ->where($qb->expr()->notIn('cc.id', $qb2->getDQL())
         );
        $qb->setParameter(1, $classe)
           ->setParameter(2, $periodeval)
           ->setParameter(3, $matiere);
        $query  = $qb->getQuery();

       return $query->getResult();
        
      
    }
    
    
}

