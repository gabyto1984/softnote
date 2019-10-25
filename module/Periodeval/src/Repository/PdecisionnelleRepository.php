<?php
namespace Periodeval\Repository;
use Doctrine\ORM\EntityRepository;
use Periodeval\Entity\Pdecisionnelle;
use Anneescolaire\Entity\Anneescolaire;
use Doctrine\ORM\Query;
/**
 * This is the custom repository class for Matiere entity.
 */
class PdecisionnelleRepository extends EntityRepository
{
    
    /**
     * Finds all published posts having any tag.
     * @return array
     */
    public function findAllPdecisionnelle()
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('m')
            ->from(Pdecisionnelle::class, 'm')
            ->orderBy('m.libele', 'DESC');
        
        return $queryBuilder->getQuery();
    }
    
    public function findPdecisionnelleHavingControle()
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('d')
            ->from(Pdecisionnelle::class, 'd')
            ->join('d.periodeval', 'm')
            ->join('m.anneescolaire', 'ma')
            ->where('ma.statut = ?1')
            ->orderBy('d.libele_periode', 'DESC')
            ->setParameter('1', 1);
        
        $pdecisionnelles = $queryBuilder->getQuery()->getResult();
        
        return $pdecisionnelles;
    }
  
       
}

