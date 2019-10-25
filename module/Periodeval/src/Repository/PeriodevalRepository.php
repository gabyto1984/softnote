<?php
namespace Periodeval\Repository;
use Doctrine\ORM\EntityRepository;
use Periodeval\Entity\Periodeval;
use Anneescolaire\Entity\Anneescolaire;
use Doctrine\ORM\Query;
/**
 * This is the custom repository class for Matiere entity.
 */
class PeriodevalRepository extends EntityRepository
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
    public function findMatiereNotInClasse($classe)
    {
       $entityManager = $this->getEntityManager();        
       $qb  = $entityManager->createQueryBuilder();
       $qb2 = $qb;
       $qb2->select('mc.id')
           ->from('Enseignee\Entity\Enseignee', 'ms')
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
    
    public function findByPeriode($periodeval)
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('p')
            ->from(Periodeval::class, 'p')
            ->join('p.evaluations', 'pe')
            ->where('pe.periodeval = ?1')
            ->setParameter('1', $periodeval);
        
        $periode = $queryBuilder->getQuery()->getResult();
        
        return $periode;
    }
    
    public function findByPeriodeForCurrentYear($CurrentYear){
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('p')
            ->from(Periodeval::class, 'p')
            ->join('p.anneescolaire', 'pa')
            ->where('pa.categorie = ?1')
            ->setParameter(1, $CurrentYear);
        
        return $queryBuilder->getQuery()->getResult();
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
    
    public function findAllPeriodeval(){
       $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('p')
            ->from(Periodeval::class, 'p')
            ->orderBy('p.description', 'DESC');
        $periodeval = $queryBuilder->getQuery()->getResult();
        
        return $periodeval; 
        
    }
       
}

