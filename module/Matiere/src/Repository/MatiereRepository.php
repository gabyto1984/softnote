<?php
namespace Matiere\Repository;
use Doctrine\ORM\EntityRepository;
use Matiere\Entity\Matiere;
use Matiere\Entity\MatiereAffectee;
use Classe\Entity\Classe;
use Matiere\Entity\Discipline;
use Doctrine\ORM\Query;
/**
 * This is the custom repository class for Matiere entity.
 */
class MatiereRepository extends EntityRepository
{
    
    /**
     * Finds all published posts having any tag.
     * @return array
     */
    public function findAllMatieres()
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('m')
            ->from(Matiere::class, 'm')
            ->orderBy('m.libele_matiere', 'DESC');
        $matieres = $queryBuilder->getQuery()->getResult();
        
        return $matieres;
    }
    
    public function findAllMatiereEvalueeClassePeriode($classe, $periode, $annee)
    {
        
    }
    public function findMatiereNotInClasse($classe)
    {
       $entityManager = $this->getEntityManager();        
       $qb  = $entityManager->createQueryBuilder();
       $qb2 = $qb;
       $qb2->select('mc.id')
           ->from('Matiere\Entity\MatiereAffectee', 'ms')
           ->Join('ms.classe', 'm')
           ->Join('ms.matiere', 'mc')
           ->where('m.id = ?1');

       $qb  = $entityManager->createQueryBuilder();
       $qb->select('mm')
           ->from('Matiere\Entity\Matiere', 'mm')
           ->where($qb->expr()->notIn('mm.id', $qb2->getDQL())
         );
        $qb->setParameter(1, $classe);
        $query  = $qb->getQuery();

       return $query->getResult();
       
    }
    
    public function findAllMatiereInClasse($classe)
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('m')
            ->from(MatiereAffectee::class, 'm')
            ->join('m.matiere', 'mm')
            ->join('m.classe', 'mc')
            ->where('mc.id = ?1')
            ->orderBy('m.coefficient', 'DESC')
            ->setParameter('1', $classe);
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    public function findAllMatiereParCoef($discipline, $classe, $periodeval)
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('ma')
            ->from(Matiere::class, 'ma')
            ->join('ma.matiereaffectee', 'mm')
            ->join('mm.evaluations', 'mme')
            ->where('ma.classe = ?1')
            ->andWhere('mme.periodeval = ?2')
            ->andWhere('ma.discipline = ?3')
            ->setParameter(1, $classe)
            ->setParameter(2, $periodeval)
            ->setParameter(3, $discipline);
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    public function findAllMatiereInClasse2($classe)
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('m')
            ->from(Matiere::class, 'm')
            ->join('m.matiereaffectee', 'mm')
            ->join('mm.classe', 'mc')
            ->where('mc.id = ?1')
            ->orderBy('mm.coefficient', 'DESC')
            ->setParameter('1', $classe);
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    public function findAllMatieresNotInClasse($classe)
    {
       $entityManager = $this->getEntityManager();        
       $qb  = $entityManager->createQueryBuilder();
       $qb2 = $qb;
       $qb2->select('mm.id')
           ->from('Matiere\Entity\MatiereAffectee', 'ms')
           ->Join('ms.classe', 'mc')
           ->Join('ms.matiere', 'mm')
           ->where('mc.id = ?1');

       $qb  = $entityManager->createQueryBuilder();
       $qb->select('mn')
           ->from('Matiere\Entity\Matiere', 'mn')
           ->where($qb->expr()->notIn('mn.id', $qb2->getDQL())
         );
        $qb->setParameter(1, $classe);
        $query  = $qb->getQuery();

       return $query->getResult();
       
    }
    
    public function findAllMatiereNotEvaluate($classe, $periodeval, $anneescolaire){
        
       $entityManager = $this->getEntityManager();        
       $qb  = $entityManager->createQueryBuilder();
       $qb2 = $qb;
       $qb2->select('mt.id')
           ->from('Evaluation\Entity\Evaluation', 'ms')
           ->Join('ms.matiere', 'mt')
           ->Join('ms.classe', 'm')
           ->Join('ms.periodeval', 'mc')
           ->Join('ms.anneescolaire', 'ma')
           ->where('m.id = ?1')
           ->andWhere('mc.id = ?2')
           ->andWhere('ma.id = ?3');

       $qb  = $entityManager->createQueryBuilder();
       $qb->select('mm')
           ->from('Matiere\Entity\Matiere', 'mm')
           ->where($qb->expr()->notIn('mm.id', $qb2->getDQL())
         );
        $qb->setParameter(1, $classe);
        $qb->setParameter(2, $periodeval);
        $qb->setParameter(3, $anneescolaire);
        
        $query  = $qb->getQuery();

       return $query->getResult();
        
    }
    
    public function findByMatiereAffectee($id_matiere)
    {
        
    }
    
     public function findDisciplinesHavingAnyMatieres()
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('d')
            ->from(Discipline::class, 'd')
            ->join('d.matieres', 'm')
            ->where('m.rang = ?1')
            ->setParameter('1', 0);
        
        $disciplines = $queryBuilder->getQuery()->getResult();
        
        return $disciplines;
    }
    public function findByDisciplinesHavingAnyMatieresEvalue($classe, $periodeval){
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('d')
            ->from(Discipline::class, 'd')
            ->join('d.matieres', 'dm')
            ->join('dm.matiereaffectees', 'dme')
            ->join('dme.evaluations', 'dmep')
            ->where('dme.classe = ?1')
            ->andWhere('dmep.periodeval = ?2')
            ->setParameter('1', $classe)
            ->setParameter('2', $periodeval);
        
        $disciplines = $queryBuilder->getQuery()->getResult();
        
        return $disciplines;
    }
    
     public function findAllMatiereInThisClasse($classe, $periode){
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('m')
            ->from(Matiere::class, 'm')
            ->join('m.matiereaffectees', 'me')
            ->join('me.evaluations', 'mee')
            ->where('me.classe = ?1')
            ->andWhere('mee.periodeval = ?2')
            ->setParameter(1, $classe)
            ->setParameter(2, $periode);
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    public function findByMatiereEvalue($discipline, $classe, $periodeval)
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('m')
            ->from(Matiere::class, 'm')
            ->join('m.matiereaffectees', 'me')
            ->join('me.evaluations', 'mee')
            ->where('me.classe = ?1')
            ->andWhere('mee.periodeval = ?2')
            ->andWhere('m.discipline = ?3')
            ->setParameter(1, $classe)
            ->setParameter(2, $periodeval)
            ->setParameter(3, $discipline);
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    public  function findByMatiere($matiere){
       $entityManager = $this->getEntityManager();
        
       $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('m')
            ->from(Matiere::class, 'm')
            ->join('m.matiereaffectees', 'mc')
            ->where('mc.matiere = ?1')
            ->setParameter('1', $matiere);
        
        return $queryBuilder->getQuery()->getResult();
  
    }
    
    public  function findByDiscipline($discipline){
       $entityManager = $this->getEntityManager();
        
       $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('m')
            ->from(Discipline::class, 'm')
            ->join('m.matieres', 'mc')
            ->where('mc.discipline = ?1')
            ->setParameter('1', $discipline);
        
        return $queryBuilder->getQuery()->getResult();
  
    }
       
}

