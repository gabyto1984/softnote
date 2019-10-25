<?php
namespace Classe\Service;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Classe\Entity\Classe;
use Classe\Entity\ClasseEleves;
use Anneescolaire\Entity\Anneescolaire;
use Matiere\Entity\MatiereAffectee;
use Zend\Filter\StaticFilter;

/**
 * The PostManager service is responsible for adding new posts, updating existing
 * posts, adding tags to post, etc.
 */
class ClasseManager
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
        $CurrentYear = 2;
               
        $annee_scolaire = $this->entityManager->getRepository(Anneescolaire::class)
                ->findOneByStatut($CurrentYear);
        $classe = new Classe();
        $classe->setLibele($data['libele']);
        $classe->setNiveau($data['niveau']);
        $classe->addAnneeScolaire($annee_scolaire);
               
        // Add the entity to entity manager.
        $this->entityManager->persist($classe);  
        $this->entityManager->flush();
    }
     /**
     * This method adds a new post.
     */
    public function addNewConfiguration($libele, $salle, $anneescolaire) 
    {
        // Create new Classe entity.
        $classe = new Classe();
        $classe->setLibele($libele);
        $classe->addSalle($salle);
        $classe->addAnneeScolaire($anneescolaire);
        
        // Add the entity to entity manager.
        $this->entityManager->persist($classe);  
        $this->entityManager->flush();
    }
     
     public function addNewMatieresAffectees($matiere, $classe, $coefficient){
        // Create new Classe entity.
        $matiereaffectee = new MatiereAffectee();
        $matiereaffectee->addMatiere($matiere);
        $matiereaffectee->addClasse($classe);
        $matiereaffectee->setCoefficient($coefficient);
        
        // Add the entity to entity manager.
        $this->entityManager->persist($matiereaffectee);  
        $this->entityManager->flush();
    }

    public function addNewEleveClasse($eleve, $classe)
    {
        $classeEleves = new ClasseEleves();
        $this->StatutActifEleve($eleve);
        $classeEleves->addEleve($eleve);
        $classeEleves->addClasse($classe);
        
        // Add the entity to entity manager.
        $this->entityManager->persist($classeEleves);  
        $this->entityManager->flush();
    }
    
    public function StatutActifEleve($eleve)
    {
        $eleve->setStatus(1);
        // Apply changes to database.
        $this->entityManager->flush();
    }
    
    public function editClasse($classe, $data) 
    {
        $classe->setLibele($data['libele']);
        $classe->setNiveau($data['niveau']);             
        // Apply changes to database.
        $this->entityManager->flush();
    }
           
    /**
     * Removes classes.
     */
    public function deleteClasse($classe) 
    {
        $this->entityManager->remove($classe);
        $this->entityManager->flush();
    }
    
}
