<?php
namespace Test\Service;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Test\Entity\Personne;
use Zend\Filter\StaticFilter;

/**
 * The PostManager service is responsible for adding new posts, updating existing
 * posts, adding tags to post, etc.
 */
class LivreManager
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
    public function addNewClasse($data) 
    {
        // Create new Classe entity.
        $classe = new Classe();
        $classe->setLibele($data['libele']);
        $classe->setNumero($data['numero']);
        $classe->setQuantite($data['quantite']);
               
        // Add the entity to entity manager.
        $this->entityManager->persist($classe);  
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
    public function deleteClasse($classe) 
    {
        $this->entityManager->remove($classe);
        $this->entityManager->flush();
    }
    
}
