<?php
namespace Periodeval\Service;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Periodeval\Entity\Periodeval;
use Periodeval\Entity\Pdecisionnelle;
use Anneescolaire\Entity\Anneescolaire;
use Zend\Filter\StaticFilter;

/**
 * The PostManager service is responsible for adding new posts, updating existing
 * posts, adding tags to post, etc.
 */
class PeriodevalManager
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager;
     */
    private $entityManager;
    
    /**
     * Constructor.
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    /**
     * This method adds a new post.
     */
    public function addNewPeriodeval($anneescolaire, $periode, $data) 
    {
        // Create new Annee entity.
        $periodeval = new Periodeval();
        $periodeval->setAnneeScolaire($anneescolaire);
        $periodeval->setDescription($data['description']);
        $periodeval->setDateDebut($data['date_debut']);
        $periodeval->setDateFin($data['date_fin']);
        $periodeval->setPeriode($periode);
        $periodeval->setCommentaires($data['commentaires']);
                     
        // Add the entity to entity manager.
        $this->entityManager->persist($periodeval);  
        $this->entityManager->flush();
    }
    
    public function addNewPdecisionnelle($data)
    {
        $pdecisionnelle = new Pdecisionnelle();
        $pdecisionnelle->setLibelePeriode($data['libele']);
        $pdecisionnelle->setType($data['type']);
                 
        // Add the entity to entity manager.
        $this->entityManager->persist($pdecisionnelle);  
        $this->entityManager->flush();  
    }
    
    /**
     * This method adds a new post.
     */
    public function addNewDiscipline($data) 
    {
        // Create new Discipline entity.
        $discipline = new Discipline();
        $discipline->setLibeleDiscipline($data['libele_discipline']);
                             
        // Add the entity to entity manager.
        $this->entityManager->persist($discipline);  
        $this->entityManager->flush();
    }
    
    public function editPeriodeval($periodeval, $anneescolaire, $data) 
    {
        $periodeval->setDescription($data['description']);
        $periodeval->setDateDebut($data['date_debut']);
        $periodeval->setDateFin($data['date_fin']);
        $periodeval->setAnneeScolaire($anneescolaire);
        $periodeval->setCommentaires($data['commentaires']);
        
        // Apply changes to database.
        $this->entityManager->flush();
    }
    
     public function editDiscipline($discipline, $data) 
    {
        $discipline->setLibeleDiscipline($data['libele_discipline']);
                           
        // Apply changes to database.
        $this->entityManager->flush();
    }
           
    /**
     * Removes periodeval.
     */
    public function deletePeriodeval($periodeval) 
    {
        $this->entityManager->remove($periodeval);
        $this->entityManager->flush();
    }
    
}
