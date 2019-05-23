<?php
namespace Evaluation\Service;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Evaluation\Entity\Evaluation;
use Zend\Filter\StaticFilter;
use Enseignee\Entity\Enseignee;
use Eleve\Entity\Eleve;
use Classeeleve\Entity\Classeeleve;

/**
 * The PostManager service is responsible for adding new posts, updating existing
 * posts, adding tags to post, etc.
 */
class EvaluationManager
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
    
   public function addNewPalmaresNotes($anneescolaire, $periodeval, $classe, $matiere, $eleve, $note){
        
        $evaluation = new Evaluation();
        $evaluation->setAnneeScolaire($anneescolaire);
        $evaluation->setPeriodeval($periodeval);
        $evaluation->setClasse($classe);
        $evaluation->setMatiere($matiere);
        $evaluation->setEleve($eleve);
        $evaluation->setNote($note);
        
         // Add the entity to entity manager.
        $this->entityManager->persist($evaluation); 
      
        $this->entityManager->flush();
    }
   
    /**
     * This method adds a new post.
     */
    public function addNewAffectation($classe, $matiere, $coef) 
    {
        // Create new Classe entity.
        $enseignee = new enseignee();
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
    
    public function CalculerMoyenne($eleve, $id_classe){
        
        $totalNote = $this->CalculerTotalNote($eleve);
        $totalCoef = $this->CalculerTotalCoef($id_classe);
        $moyenne = number_format(($totalNote * 10)/$totalCoef, 2, ',','');
        
        return $moyenne;
    }
    
    public function CalculerTotalCoef($id_classe){
        
        $classeMatiere = $this->entityManager->getRepository(Enseignee::class)
               ->findAllMatiereCoef($id_classe);
        $y = 0;
           $totalCoefficient = array();
         foreach ($classeMatiere as $enseignee){
            
             $totalCoefficient[$y]  = intval($enseignee->getCoefficient());
             $y++; 
          } 
        $totalCoef = array_sum($totalCoefficient);
        
        return $totalCoef;
    }
    
    public function CalculerTotalNote($eleve){
              
         $evaluations = $this->entityManager->getRepository(Evaluation::class)
                ->findAllNotesEleve($eleve);
           $y = 0;
         foreach ($evaluations as $evaluation){
            
             $totalNote[$y]  = intval($evaluation->getNote());
             $y++; 
          } 
        $totalNoteEleve = array_sum($totalNote);
        
        return $totalNoteEleve;
    }
    
   
            
    
}
