<?php
namespace Anneescolaire\Service;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Anneescolaire\Entity\Anneescolaire;
use Matiere\Entity\Discipline;
use Zend\Filter\StaticFilter;

/**
 * The PostManager service is responsible for adding new posts, updating existing
 * posts, adding tags to post, etc.
 */
class AnneescolaireManager
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
    public function addNewAnneeScolaire($data) 
    {
        // Create new Annee entity.
        $anneescolaire = new Anneescolaire();
        $anneescolaire->setLibele($data['libele']);
        $anneescolaire->setStatut($data['statut']);
        $anneescolaire->setStatut($data['categorie']);
        $anneescolaire->setCommentaires($data['commentaires']);
                     
        // Add the entity to entity manager.
        $this->entityManager->persist($anneescolaire);  
        $this->entityManager->flush();
    }
    
       
    public function editAnneeScolaire($anneescolaire, $data) 
    {
        $anneescolaire->setLibele($data['libele']);
        $anneescolaire->setStatut($data['statut']);
        $anneescolaire->setCategorie($data['categorie']);
        $anneescolaire->setCommentaires($data['commentaires']);
                             
        // Apply changes to database.
        $this->entityManager->flush();
    }
    
    public function editStatutAnneeScolaire($ancienne_annee_active)
    {
       $ancienne_annee_active->setStatut(2); 
       // Apply changes to database.
        $this->entityManager->flush();
    }
    
    /**
     * Removes $anneescolaire.
     */
    public function deleteAnneeScolaire($anneescolaire) 
    {
        $this->entityManager->remove($anneescolaire);
        $this->entityManager->flush();
    }
    
}
