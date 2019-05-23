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
    public function findAllClassesHavingMatiere()
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('c')
            ->from(Classe::class, 'c')
            ->join('c.enseignees', 'ce')
            ->join('c.classeEleve', 'cc')
            ->orderBy('c.libele', 'DESC');
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    public function findAllNotesEleve($eleve){
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('e')
            ->from(Evaluation::class, 'e')
            ->join('e.eleve', 'ee')
            ->where('e.eleve= ?1')
            ->setParameter('1', $eleve);
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    public function findAllNotesPeriodeClasseEleves($classe, $periodeval)
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('e')
            ->from(Evaluation::class, 'e')
            ->where('e.periodeval= ?1')
            ->andWhere('e.classe= ?2')
            ->setParameter('1', $periodeval)
            ->setParameter('2', $classe);
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    public function findNotes($eleve, $classe, $periodeval){
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('e')
            ->from(Evaluation::class, 'e')
            ->where('e.periodeval= ?1')
            ->andWhere('e.classe= ?2')
            ->andWhere('e.eleve= ?3')
            ->setParameter('1', $periodeval)
            ->setParameter('2', $classe)
            ->setParameter('3', $eleve);
        
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
       
}

