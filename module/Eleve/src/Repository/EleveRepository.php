<?php
namespace Eleve\Repository;
use Doctrine\ORM\EntityRepository;
use Eleve\Entity\Eleve;
use Evaluation\Entity\Evaluation;
use Classe\Entity\ClasseEleves;
use Classe\Entity\Classe;
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
    
    public function findAllEleves2()
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('e')
            ->from(Eleve::class, 'e')
            ->where('e.status = ?1')
            ->orderBy('e.date_naissance', 'DESC')
            ->setParameter('1', Eleve::STATUS_ADMIS);
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    public function findAllElevesAdmis($classe)
    {
       $entityManager = $this->getEntityManager();        
       $qb  = $entityManager->createQueryBuilder();
       $qb2 = $qb;
       $qb2->select('me.id')
           ->from('Classe\Entity\ClasseEleves', 'mm')
           ->join('mm.eleve', 'me')
           ->join('mm.classe', 'mc');

       $qb  = $entityManager->createQueryBuilder();
       $qb->select('mn')
           ->from('Eleve\Entity\Eleve', 'mn')
           ->where($qb->expr()->notIn('mn.id', $qb2->getDQL())
         );
        //$qb->setParameter('1', $classe);
        $query  = $qb->getQuery();

       return $query->getResult();
        
    }
    
    public function findAllEleveNonEvalue($classe, $periodeval, $matiere)
    {
       $entityManager = $this->getEntityManager();        
       $qb  = $entityManager->createQueryBuilder();
       $qb2 = $qb;
      
       $qb2->select('mm.id')
           ->from('Classe\Entity\ClasseEleves', 'mm')
           ->join('mm.evaluations', 'mme')
           ->join('mme.periodeval', 'mp')
           ->join('mme.matiere_affectee', 'mmea')
           ->join('mm.classe', 'mc')
           ->where('mc.id = ?1')
           ->andWhere('mp.id = ?2')
           ->andWhere('mmea.matiere = ?3');
       
       $qb  = $entityManager->createQueryBuilder();
       $qb->select('cc')
           ->from('Classe\Entity\ClasseEleves', 'cc')
           ->where('cc.classe = ?4')
           ->andWhere($qb->expr()->notIn('cc.id', $qb2->getDQL())
         );
        $qb->setParameter(1, $classe)
           ->setParameter(2, $periodeval)
           ->setParameter(3, $matiere)
           ->setParameter(4, $classe);
        $query  = $qb->getQuery();

       return $query->getResult();
        
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
    
    public function findByElevesNotesClasse($classe, $periode){
        
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('e')
            ->from(Eleve::class, 'e')
            ->join('e.classeeleve', 'ce')
            ->join('ce.evaluations', 'ee')
            ->where('ce.classe = ?1')
            ->andWhere('ee.periodeval = ?2')
            ->orderBy('e.nom_eleve', 'DESC')
            ->setParameter('1', $classe)
            ->setParameter('2', $periode);
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    public  function findByEleve($eleve){
       $entityManager = $this->getEntityManager();
        
       $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('m')
            ->from(Eleve::class, 'm')
            ->join('m.classeeleve', 'mc')
            ->where('mc.eleve = ?1')
            ->setParameter('1', $eleve);
        
        return $queryBuilder->getQuery()->getResult();
  
    }
    
   
}

