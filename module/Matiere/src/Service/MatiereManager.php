<?php
namespace Matiere\Service;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Matiere\Entity\Matiere;
use Matiere\Entity\Discipline;
use Zend\Filter\StaticFilter;

/**
 * The PostManager service is responsible for adding new posts, updating existing
 * posts, adding tags to post, etc.
 */
class MatiereManager
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
    public function addNewMatiere($discipline, $libele_matiere, $abrege, $rang) 
    {
        // Create new Matiere entity.
        $matiere = new Matiere();
        $matiere->setDiscipline($discipline);
        $matiere->setLibeleMatiere($libele_matiere);
        $matiere->setAbrege($abrege);
        $matiere->setRang($rang);
                     
        // Add the entity to entity manager.
        $this->entityManager->persist($matiere);  
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
    public function deleteMatiereAffectee($matiereaffectee)
    {
       $this->entityManager->remove($matiereaffectee);
        $this->entityManager->flush(); 
    }
    
    public function editMatiere($matiere, $data) 
    {
        $matiere->setLibeleMatiere($data['libele_matiere']);
        $matiere->setAbrege($data['abrege']);
        //$matiere->setDiscipline($discipline);
        $matiere->setRang($data['rang']);
                     
        // Apply changes to database.
        $this->entityManager->flush();
    }
    
     public function editDiscipline($discipline, $data) 
    {
        $discipline->setLibeleDiscipline($data['libele_discipline']);
        $discipline->setAbrege($data['abrege']);                   
        // Apply changes to database.
        $this->entityManager->flush();
    }
           
    /**
     * Removes matiere.
     */
    public function deleteMatiere($matiere) 
    {
        $this->entityManager->remove($matiere);
        $this->entityManager->flush();
    }
    
     /**
     * Removes discipline.
     */
    public function deleteDiscipline($discipline) 
    {
        $this->entityManager->remove($discipline);
        $this->entityManager->flush();
    }
    
}
