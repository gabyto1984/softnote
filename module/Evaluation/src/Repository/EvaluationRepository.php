<?php
namespace Evaluation\Repository;
use Doctrine\ORM\EntityRepository;
use Evaluation\Entity\Evaluation;
use Classe\Entity\Classe;
use Matiere\Entity\Matiere;
use Doctrine\ORM\Query;
/**
 * This is the custom repository class for Enseignee entity.
 */
class EvaluationRepository extends EntityRepository
{
    
    /**
     * Finds all published posts having any tag.
     * @return array
     */
    
    
    public function findAllNotesEleve($eleve, $classe, $periodeval){
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('e')
            ->from(Evaluation::class, 'e')
            ->join('e.matiere_affectee', 'em')
            ->join('e.eleve_inscrit', 'ei')
            ->where('ei.eleve= ?1')  
            ->andWhere('em.classe= ?2')
            ->andWhere('e.periodeval= ?3')
            ->setParameter('1', $eleve)
            ->setParameter('2', $classe)
            ->setParameter('3', $periodeval);
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    //public function findAllNotesEleveByDiscipline($eleve, $classe, $periodeval, $discipline)
    //{
        
    //}
    
    public function findAllEleveNonEvalue($classe, $periodeval, $matiere)
    {
       $entityManager = $this->getEntityManager();        
       $qb  = $entityManager->createQueryBuilder();
       $qb2 = $qb;
      
       $qb2->select('mme.id')
           ->from(Evaluation::class, 'mm')
           ->join('mm.eleve_inscrit', 'mme')  
           ->Join('mm.periodeval', 'mmp');
           //->join('mme.matiere_affectee', 'mmea')
           //->join('mm.classe', 'mc')
           //->where('mc.id = ?1')
           //->andWhere('mp.id = ?2')
           //->andWhere('mmea.id = ?3');
       
       $qb  = $entityManager->createQueryBuilder();
       $qb->select('cc')
           ->from('Eleve\Entity\Eleve', 'cc')
           ->where($qb->expr()->notIn('cc.id', $qb2->getDQL())
         );
        //$qb->setParameter(1, $matiere)
          // ->setParameter(2, $classe)
          // ->setParameter(3, $periodeval);
        $query  = $qb->getQuery();

       return $query->getResult();
        /*$entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('e')
            ->from(Eleve::class, 'e')
            ->join('e.classeeleve', 'ce')
            ->join('ce.evaluations', 'ee')
            ->where('ce.classe = ?1')
            ->andWhere('ee.periodeval = ?2')
            ->orderBy('e.nom_eleve', 'DESC')
            ->setParameter('1', $classe)
            ->setParameter('2', $periodeval);
        
        return $queryBuilder->getQuery()->getResult();*/
    }
    
    public function findAllNotesEleveByDiscipline($eleve, $discipline, $classe, $periodeval)
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('e')
            ->from(Evaluation::class, 'e')
            ->join('e.matiere_affectee', 'em')
            ->join('em.matiere', 'emm')
            ->join('emm.discipline', 'emmd')
            ->join('e.eleve_inscrit', 'ei')
            ->where('e.periodeval= ?1')
            ->andWhere('ei.classe= ?2')
            ->andWhere('ei.eleve= ?3')
            ->andWhere('emm.discipline= ?4')
            ->setParameter('1', $periodeval)
            ->setParameter('2', $classe)
            ->setParameter('3', $eleve)
            ->setParameter('4', $discipline);
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    public function findAllNotesPeriodeClasseEleves($classe, $periodeval)
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('e')
            ->from(Evaluation::class, 'e')
            ->join('e.matiere_affectee', 'em')
            ->join('e.eleve_inscrit', 'ei')
            ->where('e.periodeval= ?1')
            ->andWhere('em.classe= ?2')
            ->setParameter('1', $periodeval)
            ->setParameter('2', $classe);
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    public function findEvalThisMatiere($matiere, $classe, $periodeval)
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('e')
            ->from(Evaluation::class, 'e')
            ->join('e.matiere_affectee', 'em')
            ->where('e.periodeval= ?1')
            ->andWhere('em.classe= ?2')
            ->andWhere('em.matiere= ?3')
            ->setParameter('1', $periodeval)
            ->setParameter('2', $classe)
            ->setParameter('3', $matiere);
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    public function findNotes($eleve, $classe, $periodeval){
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('e')
            ->from(Evaluation::class, 'e')
            ->join('e.matiere_affectee', 'em')
            ->join('e.eleve_inscrit', 'ei')
            ->where('e.periodeval= ?1')
            ->andWhere('ei.classe= ?2')
            ->andWhere('ei.eleve= ?3')
            ->setParameter('1', $periodeval)
            ->setParameter('2', $classe)
            ->setParameter('3', $eleve);
        
        return $queryBuilder->getQuery()->getResult();
    }
    public function findAllNotesClasseByDiscipline($discipline, $classe, $periodeval)
    {
       $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('e')
            ->from(Evaluation::class, 'e')
            ->join('e.matiere_affectee', 'em')
            ->join('em.matiere', 'emm')
            ->join('emm.discipline', 'emmd')
            ->where('e.periodeval= ?1')
            ->andWhere('em.classe= ?2')
            ->andWhere('emm.discipline= ?3')
            ->setParameter('1', $periodeval)
            ->setParameter('2', $classe)
            ->setParameter('3', $discipline);
        
        return $queryBuilder->getQuery()->getResult(); 
    }
    
    public function findAllMatiereClasse($classe)
    {
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
    
    public function findAllNotesMatiere($matiere, $classe, $periodeval)
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('e')
            ->from(Evaluation::class, 'e')
            ->join('e.matiere_affectee', 'em')
            ->where('e.periodeval= ?1')
            ->andWhere('em.classe= ?2')
            ->andWhere('em.matiere= ?3')
            ->setParameter('1', $periodeval)
            ->setParameter('2', $classe)
            ->setParameter('3', $matiere);
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    public function findAllNotesMinimum($matiere, $discipline, $classe, $periodeval)
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('e')
            ->from(Evaluation::class, 'e')
            ->join('e.matiere_affectee', 'em')
            ->join('em.matiere', 'emm')
            ->where('e.periodeval= ?1')
            ->andWhere('em.classe= ?2')
            ->andWhere('em.matiere= ?3')
            ->andWhere('emm.discipline= ?4')
            ->setParameter('1', $periodeval)
            ->setParameter('2', $classe)
            ->setParameter('3', $matiere)
            ->setParameter('4', $discipline);
        
        return $queryBuilder->getQuery()->getResult();
    }
       
}

