<?php
namespace Test\Repository;
use Doctrine\ORM\EntityRepository;
use Test\Entity\Emprunter;
use Doctrine\ORM\Query;
/**
 * This is the custom repository class for Classe entity.
 */
class EmprunterRepository extends EntityRepository
{
    
    /**
     * Finds all published posts having any tag.
     * @return array
     */
    public function findAllEmprunts()
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('c')
            ->from(Emprunter::class, 'c')
            ->orderBy('c.date_emprunt', 'DESC');
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    
}

