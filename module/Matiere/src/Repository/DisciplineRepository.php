<?php
namespace Matiere\Repository;
use Doctrine\ORM\EntityRepository;
use Matiere\Entity\Discipline;
use Doctrine\ORM\Query;
/**
 * This is the custom repository class for Matiere entity.
 */
class DisciplineRepository extends EntityRepository
{
    
    /**
     * Finds all published posts having any tag.
     * @return array
     */
    public function findAllDisciplines()
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('m')
            ->from(Discipline::class, 'm')
            ->orderBy('m.libele_discipline', 'DESC');
        
        return $queryBuilder->getQuery();
    }
    
     
    
    
       
}

