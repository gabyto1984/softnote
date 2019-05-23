<?php
namespace Enseignee\Service;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Enseignee\Entity\Enseignee;
use Zend\Filter\StaticFilter;

/**
 * The PostManager service is responsible for adding new posts, updating existing
 * posts, adding tags to post, etc.
 */
class EnseigneeManager
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
    public function addNewAffectation($periode, $classe, $matiere, $coef) 
    {
        // Create new Classe entity.
        $enseignee = new enseignee();
        $enseignee->addPeriodeval($periode);
        $enseignee->addClasse($classe);
        $enseignee->addMatiere($matiere);
        $enseignee->setCoefficient($coef);
               
        // Add the entity to entity manager.
        $this->entityManager->persist($enseignee);  
        $this->entityManager->flush();
    }
    
    public function editClasse($classe, $data) 
    {
        $classe->setLibele($data['libele']);
        $classe->setNumero($data['numero']);
        $classe->setQuantite($data['quantite']);
             
        // Apply changes to database.
        $this->entityManager->flush();
    }
           
    /**
     * Removes tickets.
     */
    
    public function deleteEnseignee($enseignee){
        $this->entityManager->remove($enseignee);
        $this->entityManager->flush();
    }
    
    
    public function deleteClasse($classe) 
    {
        $this->entityManager->remove($classe);
        $this->entityManager->flush();
    }
    
}
