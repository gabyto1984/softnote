<?php
namespace Ecole\Repository;
use Doctrine\ORM\EntityRepository;
use Ecole\Entity\Ecole;
use Doctrine\ORM\Query;
/**
 * This is the custom repository class for Salle entity.
 */
class EcoleRepository extends EntityRepository
{
    
    /**
     * Finds all published posts having any tag.
     * @return array
     */
    public function findAllEcoles()
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('c')
            ->from(Ecole::class, 'c')
            ->orderBy('c.nom', 'DESC');
        
        return $queryBuilder->getQuery()->getResult();
    }
      
}

