<?php
namespace Classeeleve\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Eleve\Entity\Eleve;
/**
 * This is the custom repository class for Classe entity.
 */
class ClasseeleveRepository extends EntityRepository
{
    
    /**
     * Finds all published posts having any tag.
     * @return array
     */
    public function findAllEleves()
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('c')
            ->from(Eleve::class, 'c')
            ->orderBy('c.nom_eleve', 'DESC');
        
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
        
        return $queryBuilder->getQuery()->getResult();;
    }        
       
}

