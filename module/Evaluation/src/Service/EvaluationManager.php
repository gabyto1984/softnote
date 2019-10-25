<?php
namespace Evaluation\Service;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Evaluation\Entity\Evaluation;
use Zend\Filter\StaticFilter;
use Enseignee\Entity\Enseignee;
use Eleve\Entity\Eleve;
use Matiere\Entity\Matiere;
use Matiere\Entity\MatiereAffectee;
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
    
   public function addNewPalmaresNotes($periodeval, $eleve, $matiere, $note){
        
        $evaluation = new Evaluation();
        $evaluation->setPeriodeval($periodeval);
        $evaluation->setEleveInscrit($eleve);
        $evaluation->setMatiereAffectee($matiere);
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
    
    public function modifierNote($evaluation, $nouvelle_note)
    {
        $evaluation->setNote($nouvelle_note);
                    
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
    
    public function CalculerMoyenne($eleve, $classe, $periodeval){
        
        $totalNote = $this->CalculerTotalNote($eleve, $classe, $periodeval);
        $totalCoef = $this->CalculerTotalCoef($classe, $periodeval);
        $moyenne = number_format(($totalNote * 10)/$totalCoef, 2, ',','');
        
        return $moyenne;
    }
    
        
    public function CalculerTotalCoef($classe, $periodeval){
        
        $classeMatiere = $this->entityManager->getRepository(MatiereAffectee::class)
               ->findAllMatiereCoef($classe, $periodeval);
        $y = 0;
           $totalCoefficient = array();
         foreach ($classeMatiere as $enseignee){
            
             $totalCoefficient[$y]  = intval($enseignee->getCoefficient());
             $y++; 
          } 
        $totalCoef = array_sum($totalCoefficient);
        
        return $totalCoef;
    }
    
    public function CalculerTotalNote($eleve, $classe, $periodeval){
              
         $evaluations = $this->entityManager->getRepository(Evaluation::class)
                ->findAllNotesEleve($eleve, $classe, $periodeval);
           $y = 0;
         foreach ($evaluations as $evaluation){
            
             $totalNote[$y]  = intval($evaluation->getNote());
             $y++; 
          } 
        $totalNoteEleve = array_sum($totalNote);
        
        return $totalNoteEleve;
    }
    
   public function CalculerTotalCoefParDiscipline($discipline, $classe, $periodeval)
   {
       $matieres = $this->entityManager->getRepository(MatiereAffectee::class)
               ->findAllMatiereParCoef($discipline, $classe, $periodeval);
       $y = 0;
       foreach ($matieres as $matiere){
           $totalNote[$y]  = intval($matiere->getCoefficient());
             $y++; 
       }
       $totalCoefParDiscipline = array_sum($totalNote);
        
        return $totalCoefParDiscipline;
   }
   
   public function CalculerTotalNoteParDiscipline($eleve, $discipline, $classe, $periodeval)
   {
       $evaluations = $this->entityManager->getRepository(Evaluation::class)
       ->findAllNotesEleveByDiscipline($eleve, $discipline, $classe, $periodeval);
       
       $y = 0;
       foreach ($evaluations as $matiere){
           $totalNote[$y]  = intval($matiere->getNote());
             $y++; 
       }
       $totalNoteParDiscipline = array_sum($totalNote);
        
        return $totalNoteParDiscipline;
   }
   
   //Calculer totale notes par discipline pour une classe pendant une periode d'evaluation
   
   public function CalculerNoteParDisciplineClasse($discipline, $classe, $periodeval)
   {
       $evaluations = $this->entityManager->getRepository(Evaluation::class)
       ->findAllNotesClasseByDiscipline($discipline, $classe, $periodeval);
       
       $y = 0;
       foreach ($evaluations as $matiere){
           $totalNote[$y]  = intval($matiere->getNote());
             $y++; 
       }
       $totalNoteParDiscipline = array_sum($totalNote);
        
        return $totalNoteParDiscipline;
   }
   
   //Calculer quantite eleve evalue dans une classe pour une periode
   
   public function CalculerQuantiteEleveEvalue($classe, $periodeval)
   {
       $eleves = $this->entityManager->getRepository(Eleve::class)
       ->findByElevesNotesClasse($classe, $periodeval);
       
        return count($eleves);
   }
   
   //Calculer total note d'une matiere pour la classe dans une periode donnee
   public function CalculerTotalNoteClasse($matiere, $classe, $periodeval)
   {
       $evaluations = $this->entityManager->getRepository(Evaluation::class)
                ->findAllNotesMatiere($matiere, $classe, $periodeval);
           $y = 0;
         foreach ($evaluations as $evaluation){
            
             $totalNote[$y]  = intval($evaluation->getNote());
             $y++; 
          } 
        $totalNoteClasse = (array_sum($totalNote)/$this->CalculerQuantiteEleveEvalue($classe, $periodeval));
        
        return $totalNoteClasse;
   }
   
   public function CalculerTotalNoteMoyenneClasse($classe, $periodeval)
   {
       $evaluations = $this->entityManager->getRepository(Evaluation::class)
                ->findAllNotesMoyenneClasse($matiere, $classe, $periodeval);
           $y = 0;
         foreach ($evaluations as $evaluation){
            
             $totalNote[$y]  = intval($evaluation->getNote());
             $y++; 
          } 
        $totalNoteClasse = (array_sum($totalNote)/$this->CalculerQuantiteEleveEvalue($classe, $periodeval));
        
        return $totalNoteClasse;
   }
   
   //Calculer le plus petit note dans une classe pour une matiere dans une periode
   public function CalculerMinimumNoteClasse($matiere, $classe, $periodeval)
   {
       $evaluations = $this->entityManager->getRepository(Evaluation::class)
                ->findAllNotesMatiere($matiere, $classe, $periodeval);
           $y = 0;
         foreach ($evaluations as $evaluation){
            
             $totalNote[$y]  = intval($evaluation->getNote());
             $y++; 
          } 
        $minimumNoteClasse = min($totalNote);
        
        return $minimumNoteClasse;
   }
   
   public function CalculerMaximumNoteClasse($matiere, $classe, $periodeval)
   {
       $evaluations = $this->entityManager->getRepository(Evaluation::class)
                ->findAllNotesMatiere($matiere, $classe, $periodeval);
           $y = 0;
         foreach ($evaluations as $evaluation){
            
             $totalNote[$y]  = intval($evaluation->getNote());
             $y++; 
          } 
        $maximumNoteClasse = max($totalNote);
        
        return $maximumNoteClasse;
   }
 
   //Calculer la position de chaque eleve
   
   public function CalculerPosition($eleve, $classe, $periodeval)
   {
      $eleves = $this->entityManager->getRepository(Eleve::class)
       ->findByElevesNotesClasse($classe, $periodeval);
        $z =0; $x=0;
        $jsonData = array();
        //$rangTotalNotes = array();
        $position=0;
         foreach ($eleves as $el){
             $evaluations = $this->entityManager->getRepository(Evaluation::class)
                ->findAllNotesEleve($el, $classe, $periodeval);
           $y = 0;
           foreach ($evaluations as $evaluation){
            
                 $totalNote[$y]  = intval($evaluation->getNote());
                 $y++; 
             } 
             
           $totalNoteEleve = array_sum($totalNote);
           $temp2 =[
                 'id'=>$el->getId(),
                 'moy' => $totalNoteEleve 
              ]; 
            $temp[] = $temp2;
           
           $z++; $x++;
                    
         } 
         usort($temp, function($a,$b){return $b['moy']-$a['moy'];});
           
         //$rangTotalNotes = array_multisort( array_column($temp, "moy"), SORT_ASC, $temp);
         foreach($temp as $key=> $value){
             if($value['id'] == $eleve->getId()){
                 $position = $key+1; 
            }
              
           }
      return $position;   
   }
   
   //Calculer le plus petit note par discipline dans une classe pour une periode
   public function CalculerMinimumNoteParDisciplineClasse($discipline, $classe, $periodeval)
   {
         
       $matieres = $this->entityManager->getRepository(Matiere::class)
                   ->findByMatiereEvalue($discipline, $classe, $periodeval);
         $x=0;
           foreach($matieres as $matiere){
               $minNote[$x] = $this->CalculerMinimumNoteClasse($matiere, $classe, $periodeval);
               $x++;
           }
        $totalMinNote = array_sum($minNote);
     
        
        return $totalMinNote;
   }
   
   public function CalculerMaximumNoteParDisciplineClasse($discipline, $classe, $periodeval)
   {
       $matieres = $this->entityManager->getRepository(Matiere::class)
                   ->findByMatiereEvalue($discipline, $classe, $periodeval);
         $x=0;
           foreach($matieres as $matiere){
               $maxNote[$x] = $this->CalculerMaximumNoteClasse($matiere, $classe, $periodeval);
               $x++;
           }
        $totalMaxNote = array_sum($maxNote);
     
        
        return $totalMaxNote;
   }
            
    
}
