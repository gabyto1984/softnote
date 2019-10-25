<?php
namespace Salle\Service;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Salle\Entity\Salle;
use Zend\Filter\StaticFilter;

/**
 * The PostManager service is responsible for adding new posts, updating existing
 * posts, adding tags to post, etc.
 */
class SalleManager
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
    public function addNewSalle($data, $classe) 
    {
        // Create new Salle entity.
        $salle = new Salle();
        $salle->addClasse($classe);
        $salle->setLibele($data['libele']);
        $salle->setNumero($data['numero']);
        $salle->setQuantite($data['quantite']);
               
        // Add the entity to entity manager.
        $this->entityManager->persist($salle);  
        $this->entityManager->flush();
    }
    
    public function editSalle($salle, $data) 
    {
        $salle->setLibele($data['libele']);
        $salle->setNumero($data['numero']);
        $salle->setQuantite($data['quantite']);
             
        // Apply changes to database.
        $this->entityManager->flush();
    }
           
    /**
     * Removes tickets.
     */
    public function deleteSalle($salle) 
    {
        $this->entityManager->remove($salle);
        $this->entityManager->flush();
    }
    
}
