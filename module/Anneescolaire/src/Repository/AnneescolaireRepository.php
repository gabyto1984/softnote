<?php
namespace Anneescolaire\Repository;
use Doctrine\ORM\EntityRepository;
use Anneescolaire\Entity\Anneescolaire;
use Matiere\Entity\Discipline;
use Doctrine\ORM\Query;
/**
 * This is the custom repository class for Matiere entity.
 */
class AnneescolaireRepository extends EntityRepository
{
    
    /**
     * Finds all published posts having any tag.
     * @return array
     */
     public function findAllAnneescolaires()
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('m')
            ->from(Anneescolaire::class, 'm')
            ->orderBy('m.libele', 'DESC');
        $anneescolaires = $queryBuilder->getQuery()->getResult();
        
        return $anneescolaires;
    }
    
    public function findTheCurrentYear($CurrentYear)
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('m')
            ->from(Anneescolaire::class, 'm')
            
            ->orderBy('m.libele', 'DESC');
        $anneescolaires = $queryBuilder->getQuery()->getResult();
        
        return $anneescolaires;
    }
    
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
    
    public function findCurrentStatusYear(){
        $entityManager = $this->getEntityManager();
        $idannee = 2;
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('as')
            ->from(Anneescolaire::class, 'as')
            ->where('as.statut = ?1')
            ->setParameter(1, $idannee);
        
        $anneescolaire = $queryBuilder->getQuery()->getResult();
        
        return $anneescolaire;
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
    
    public function findByAnnee($anneescolaire)
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('m')
            ->from(Anneescolaire::class, 'm')
            ->join('m.periodevals', 'mc')
            ->join('mc.evaluations', 'mce')
            ->where('mc.anneescolaire = ?1')
            ->setParameter('1', $anneescolaire);
        
        $anneescolaires = $queryBuilder->getQuery()->getResult();
        
        return $anneescolaires;
        
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
       
}

