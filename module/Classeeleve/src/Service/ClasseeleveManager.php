<?php
namespace Classeeleve\Service;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\Filter\StaticFilter;
use Classeeleve\Entity\Classeeleve;

/**
 * The PostManager service is responsible for adding new posts, updating existing
 * posts, adding tags to post, etc.
 */
class ClasseeleveManager
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
    public function addNewAffectation($anneescolaire, $classe, $eleve) 
    {
        // Create new Classe entity.
        $classeEleve = new Classeeleve();
        $classeEleve->addClasse($classe);
        $classeEleve->addAnneescolaire($anneescolaire);
        $classeEleve->addEleve($eleve);
        $this->changerStatut($eleve);
        // Add the entity to entity manager.
        $this->entityManager->persist($classeEleve);  
        $this->entityManager->flush();
    }
    
    public function changerStatut($eleve){
       $eleve->setStatus('1');
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
