<?php
namespace Classe\Repository;
use Doctrine\ORM\EntityRepository;
use Classe\Entity\Classe;
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
            ->orderBy('c.libele', 'DESC');
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    
}

