<?php
namespace Evaluation\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\View\Renderer\RendererInterface;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use DOMPDFModule\View\Model\PdfModel;
use Evaluation\Form\EvaluationForm;
use Evaluation\Form\PalmaresForm;
use Evaluation\Entity\Evaluation;
use Classe\Entity\Classe;
use Matiere\Entity\Matiere;
use Enseignee\Entity\Enseignee;
use Anneescolaire\Entity\Anneescolaire;
use Periodeval\Entity\Periodeval;
use Eleve\Entity\Eleve;
use \TCPDF; 



class EvaluationController extends AbstractActionController
{
    /**
     * Session container.
     * @var Zend\Session\Container
     */
    private $sessionContainer;
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager 
     */
    private $entityManager;
    
    /**
     * Entity manager.
     * @var \TCPDF 
     */
    private $tcpdf;
    
    /**
     * Croyant manager.
     * @var Evaluation\Service\EvaluationManager 
     */
    private $evaluationManager;
    
    /**
     * @var RendererInterface
     */
    protected $renderer;
    
    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager, $evaluationManager, $tcpdf, $renderer) 
    {
        $this->entityManager = $entityManager;
        $this->evaluationManager = $evaluationManager;
        $this->tcpdf = $tcpdf;
        $this->renderer = $renderer;
    }
  
    public function indexAction()
    {
        $CurrentYear = 2;
        $classes = $this->entityManager->getRepository(Evaluation::class)
                ->findAllClassesHavingMatiere();
        
        $anneescolaire = $this->entityManager->getRepository(Anneescolaire::class)
                ->findOneByStatut($CurrentYear);
        
        $periodevals = $this->entityManager->getRepository(Periodeval::class)
                ->findThePeriodeForCurrentYear($CurrentYear);
        
        return new ViewModel([
            'classes' => $classes,
            'anneescolaire' =>  $anneescolaire,
            'periodevals' => $periodevals
        ]);
      
    }
    
    public function palmaresAction(){
      
        // Create the form.
        $form = new PalmaresForm();
        
        $CurrentYear = 2;
        $periodeval = 0;
        
        $anneescolaire = $this->entityManager->getRepository(Anneescolaire::class)
                ->findOneByStatut($CurrentYear);
        if ($anneescolaire == null) {
            $this->getResponse()->setStatusCode(404);
            return;                        
        }
        
        foreach($this->entityManager->getRepository(Periodeval::class)->findThePeriodeForCurrentYear($CurrentYear) as $periodeval) {
        $optionsPeriode[$periodeval->getId()] = $periodeval->getDescription();
        }
        $form->get('periodeval')->setValueOptions($optionsPeriode);
        
        foreach($this->entityManager->getRepository(Evaluation::class)->findAllClassesHavingMatiere() as $classe) {
        $optionsClasse[$classe->getId()] = $classe->getLibele();
        }
        $form->get('classe')->setValueOptions($optionsClasse);
        $DataEleves = array();
        if ($this->getRequest()->isPost()) {
            
            
            // Get POST data.
         $data = $this->params()->fromPost();
         
         // Fill form with data.
         $form->setData($data);
         
    
        $periode = $this->entityManager->getRepository(Periodeval::class)
                ->findOneById($data['periodeval']);
        
        $classe = $this->entityManager->getRepository(Classe::class)
                ->findOneById($data['classe']);
        
        $eleves = $this->entityManager->getRepository(Eleve::class)
                ->findAllElevesNotesClasse($data['classe'], $data['periodeval']);
        
        $totalNote = array();
        $moyenne = array();
        $totalEleve = array();
        $note = 0;
        $i = 0;
        foreach($eleves  as $eleve) { 
          
           $evaluations = $this->entityManager->getRepository(Evaluation::class)
                ->findAllNotesEleve($eleve);
           $y = 0;
         foreach ($evaluations as $evaluation){
            
             $totalNote[$y]  = intval($evaluation->getNote());
             $y++; 
          } 
        $totalEleve[$i] = array_sum($totalNote);
         $moyenne[$i] = $this->evaluationManager->CalculerMoyenne($eleve, $data['classe']);
        $i++;
       
        }
         
         $idx = 0;
         $y2 = 0;
           foreach($eleves  as $eleve) { 
              
              $temp =[
                 'id_eleve' =>$eleve->getId(),
                 'nom' => $eleve->getNomEleve(), 
                 'prenom' => $eleve->getPrenomEleve(),
                 'totalNote' => $totalEleve[$y2],
                 'moyenne' => $moyenne[$y2]
              ]; 
              $y2++;
             $DataEleves[$idx++] = $temp; 
           }
         $periodeval = $periode->getId();     
      }
      
      $data = [
                'anneescolaire' => $anneescolaire->getLibele(),  
            ];
      $form->setData($data);
       return new ViewModel([
            'form' => $form,
            'palmaresEleves' => $DataEleves,
            'classe' => $classe->getId(),
            'periodeval' => $periodeval,
        ]);
    }
    public function palmaresnotesAction(){
       $CurrentYear = 2;
        $classes = $this->entityManager->getRepository(Evaluation::class)
                ->findAllClassesHavingMatiere();
        
        $anneescolaire = $this->entityManager->getRepository(Anneescolaire::class)
                ->findOneByStatut($CurrentYear);
        
        $periodevals = $this->entityManager->getRepository(Periodeval::class)
                ->findThePeriodeForCurrentYear($CurrentYear);
        
        return new ViewModel([
            'classes' => $classes,
            'anneescolaire' =>  $anneescolaire,
            'periodevals' => $periodevals
        ]); 
    }
    
    public function afficherMatiereEvalueeClassePeriodeAction()
    {
        
        $id_classe = $_POST['classe'];
        $id_periode = $_POST['periode'];
        $id_annee = $_POST['annee'];
        
        $classe = $this->entityManager->getRepository(Classe::class)
               ->findOneById($id_classe);
        
        $periodeval = $this->entityManager->getRepository(Periodeval::class)
               ->findOneById($id_periode);
        
        $anneescolaire = $this->entityManager->getRepository(Anneescolaire::class)
               ->findOneById($id_annee);
        
        $evaluations = $this->entityManager->getRepository(Evaluation::class)
                  ->findAllNotesPeriodeClasseEleves($classe, $periodeval);
        
        $allDisciplines = $this->entityManager->getRepository(Matiere::class)
                  ->findDisciplinesHavingAnyMatieresEvalue($classe, $periodeval);
        
        $eleves = $this->entityManager->getRepository(Eleve::class)
                ->findAllElevesNotesClasse($classe, $periodeval);
        
        $request = $this->getRequest(); 
         if ($request->isXmlHttpRequest()) { 
           $jsonDataMatiere = array();
           $jsonDataEleve = array();
           $jsonDataEleveNotes = array();
           $notes = array();
           $jsonData = array();
           $nbrmat = 0;
           $nbrel= 0;
           $i=0;
           $totalNote = array();
           $moyenne = array();
           $totalNotesEleve = array();
           
           foreach ($allDisciplines as $discipline){
           foreach($discipline->getMatieres()  as $matiere) { 
              $temp =[
                 'id_enseignee' =>$matiere->getId(),
                 'libele' => $matiere->getLibeleMatiere(), 
                 'abrege' => $matiere->getAbrege(),
                 'rang' => $matiere->getRangAsString(),
              ];  
             $jsonDataMatiere[$nbrmat++] = $temp; 
           }
           }
           $ne=0;  $y2=0;
           foreach($eleves as $eleve){
             $y=0;
              //$jsonDataEleveNotes[$i]= $temp2;
                
                  $matiere = $this->entityManager->getRepository(Matiere::class)->findOneById($jsonDataMatiere[$i]['id_enseignee']);
                  $evaluations = $this->entityManager->getRepository(Evaluation::class)
                          ->findNotes($eleve, $classe, $periodeval);
                  $evaluationsNotes = $this->entityManager->getRepository(Evaluation::class)
                           ->findAllNotesEleve($eleve);
                   $z =0;
                  foreach($evaluations as $evaluation){
                      $temp3 =[
                          'note'=> $evaluation->getNote(),
                      ];
                     $jsonDataEleveNotes[$ne][$y] = $temp3;
                     $totalNote[$z]  = intval($evaluation->getNote());
             
                  $y++;  $z++; 
                }
              $totalNotesEleve[$i] = array_sum($totalNote);
              $moyenne[$i] = $this->evaluationManager->CalculerMoyenne($eleve, $classe);
         
             $temp2 =[
                 'id'=>$eleve->getId(),
                 'nom' => $eleve->getNomEleve(), 
                 'prenom' => $eleve->getPrenomEleve(),
                 'totalNote' => $totalNotesEleve[$y2],
                 'moyenne' => $moyenne[$y2]
              ];  
             
             $jsonDataEleve[$nbrel++] = $temp2;
             
             $i++; $ne++; $y2++;
           }
           
           $jsonData[0] = $jsonDataMatiere;
           $jsonData[1] =$jsonDataEleve;
           $jsonData[2]= $jsonDataEleveNotes;
           
           $view = new JsonModel($jsonData); 
           $view->setTerminal(true); 
          } else { 
             $view = new ViewModel(); 
        }  
       
      return $view;  
        
    }
    
    public function imprimerAction(){
      $id_eleve = (int)$this->params()->fromRoute('id', -1);
      $id_classe = (int)$this->params()->fromRoute('classe', -1);
      $id_periode = (int)$this->params()->fromRoute('periode', -1);
        if ($id_eleve<1) {
          $this->getResponse()->setStatusCode(404);
            return;
       } 
      $periode = $this->entityManager->getRepository(Periodeval::class)
                ->findOneById($id_periode);
      $classe = $this->entityManager->getRepository(Classe::class)
                ->findOneById($id_classe);
      $matieres = $this->entityManager->getRepository(Matiere::class)->findAllMatiereInThisClasse($classe);
        
     $allDiscipline = $this->entityManager->getRepository(Matiere::class)->findDisciplinesHavingAnyMatieresEvalue($classe, $periode);
     $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
     $nom='Gabriel';
     $prenom='Antoinius';
     $pdf->SetCreator(PDF_CREATOR);
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->SetTitle('Bulletin Scolaire');
            $pdf->AddPage();
            $pdf->setFormDefaultProp(array('lineWidth'=>1, 'borderStyle'=>'solid', 'fillColor'=>array(255, 255, 200), 'strokeColor'=>array(255, 128, 128)));

            $pdf->SetFont('helvetica', 'BI', 18);
            $pdf->Ln(5);
            $pdf->Cell(0, 4, 'Bulletin Scolaire', 0, 1, 'C');
            $pdf->Ln(10);
            
             //$width_cell=array(40,40,40,70);
            $pdf->SetFont('helvetica','',12);

            //Background color of header//
            $pdf->SetFillColor(193,229,252);
                
            $pdf->Cell(30,11,'Matiere',1,0,'C',true);
            $pdf->Cell(40,5,'Moyennes',1,0,'C',true);
            $pdf->Cell(40,5,'Notes ex',1,0,'C',true);
            $pdf->Cell(80,11,'details',1,0,'C',true);
            $pdf->Cell(0,5,'',0,1);
            
            $pdf->Cell(30,4,'',0,0);
            $pdf->Cell(20,4,'q1',1,0,true);
            $pdf->Cell(20,4,'q2',1,0,true);
            $pdf->Cell(20,4,'q3',1,0,true);
            $pdf->Cell(20,4,'q4',1,1,true);
            
            foreach ($allDiscipline as $discipline) {
            
            $pdf->Cell(30,5,$discipline->getLibeleDiscipline(),1,0,'L');
            $pdf->Cell(20,5,'Moy',1,0,'C');
            $pdf->Cell(20,5,'No',1,0,'C');
            $pdf->Cell(20,5,'M',1,0,'C');
            $pdf->Cell(20,5,'N',1,0,'C');
            $pdf->Cell(80,5,'details',1,1,'C');
               foreach ($discipline->getMatieres() as $matiere){
                    $pdf->Cell(30,5,'-'.$matiere->getLibeleMatiere(),1,0,'L');
                    $pdf->Cell(20,5,'Moy',1,0,'C');
                    $pdf->Cell(20,5,'No',1,0,'C');
                    $pdf->Cell(20,5,'M',1,0,'C');
                    $pdf->Cell(20,5,'N',1,0,'C');
                    $pdf->Cell(80,5,'details',1,1,'C');
               }
            
            }
            
            $pdf->SetFont('helvetica', '', 12);
            
            $pdf->lastPage();
            $pdf->Output('example', 'I');
        
        return false;
        
    }
    
    
    
    public function afficherTotalCoefAction(){
        $id_classe = $_POST['classe'];
        $classeMatiere = $this->entityManager->getRepository(Enseignee::class)
               ->findAllMatiereCoef($id_classe);
        
         $request = $this->getRequest(); 
         if ($request->isXmlHttpRequest()) { 
           
           $y = 0;
           $totalCoefficient = array();
         foreach ($classeMatiere as $enseignee){
            
             $totalCoefficient[$y]  = intval($enseignee->getCoefficient());
             $y++; 
          } 
        $totalCoef = array_sum($totalCoefficient);
      
          $jsonData = array('totalCoef' => $totalCoef); 
       $view = new JsonModel($jsonData); 
           $view->setTerminal(true);
      } else { 
             $view = new ViewModel(); 
        }           
      return $view;
    }
    
    public function addAction() 
    {   
       $json_string = $_POST['postData'];
       
       $id_annee = $_POST['annee'];
       $id_periodeval = $_POST['periodeval'];
       $id_classe = $_POST['classe'];
       $id_matiere = $_POST['matiere'];
       
       $nbeleve = count($json_string);
        if($nbeleve > 0){
            
        $anneescolaire = $this->entityManager->getRepository(Anneescolaire::class)
               ->findOneById($id_annee);
        
        $periodeval = $this->entityManager->getRepository(Periodeval::class)
               ->findOneById($id_periodeval);
        
        $classe = $this->entityManager->getRepository(Classe::class)
               ->findOneById($id_classe);
        
        $matiere = $this->entityManager->getRepository(Matiere::class)
               ->findOneById($id_matiere);
        
        for($i=0; $i<$nbeleve; $i++){
            $eleve= $this->entityManager->getRepository(Eleve::class)
                 ->findOneById($json_string[$i]['id_eleve']);
                $this->evaluationManager->addNewPalmaresNotes($anneescolaire, $periodeval, $classe, $matiere, $eleve, $json_string[$i]['note']);
         }
       }
       $jsonData = array(
               'libele' => $id_matiere,
               'rang' => 'testok',
               'coefficient' => 'testok',
           );
       //$jsonData = array(); 
       //$jsonData[1]=['id' => 'Success',  
               //  'categorie' =>"'".$json_string[0]['id_matiere']."'",
           //]; 
       $view = new JsonModel($jsonData); 
           $view->setTerminal(true);
           
      return $view;
        
    }
    
public function printpdfAction()
{ 
    //$this->layout(FALSE);
     $allDiscipline = $this->entityManager->getRepository(Matiere::class)->findDisciplinesHavingAnyMatieres();
     $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
     $nom='Gabriel';
     $prenom='Antoinius';
     $pdf->SetCreator(PDF_CREATOR);
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->SetTitle('Bulletin Scolaire');
            $pdf->AddPage();
            $html ="<style>
            th{border:0.5px solid #C0C0C0;background-color:rgb(44,126,193); font-size: 9pt;text-align: center;color:#FFFFFF;font-weight:bold;}
            td{ vertical-align: middle;padding-top:5px;border:0.5px solid #C0C0C0;padding:5pt;color:#000000;background-color:#FFFFFF;font-size: 8pt;text-align: center;}
            </style>
            <table>
            <thead>
            <tr nobr=”true”><th>Discipline</th><th>Note</th></tr>
            </thead><tbody>
            <tr nobr=”true”>
            <td>Discipline</td>
            <td>$nom</td>
            </tr>
            </tbody>
            </table>";

            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->lastPage();
            //$pdf->Output('example', 'I');*
            
           // $pdf->setVariables([
       // 'message' => 'This is a test message'
    //]);
              $jsonData = array(
               'pdf' => $pdf);
       //$jsonData = array(); 
       //$jsonData[1]=['id' => 'Success',  
               //  'categorie' =>'',
           //]; 
       $view = new JsonModel($jsonData); 
           $view->setTerminal(true);
           
      return $view;
}
    
   public function viewAction() 
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Find an entite with such ID.
        $classe = $this->entityManager->getRepository(Classe::class)
                ->findOneById($id);
        
        if ($classe == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
                
        return new ViewModel([
            'classe' => $classe
        ]);
    }
    
    
     public function editAction() 
    {
        // Create form.
        $form = new EventForm();
        
        // Get event ID.
        $eventId = (int)$this->params()->fromRoute('id', -1);
        
        // Validate input parameter
        if ($eventId<0) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Find the existing event in the database.
        $event = $this->entityManager->getRepository(Event::class)
                ->findOneById($eventId);        
        if ($event == null) {
            $this->getResponse()->setStatusCode(404);
            return;                        
        } 
        // Check whether this event is a POST request.
        if ($this->getRequest()->isPost()) {
            
            // Get POST data.
            $data = $this->params()->fromPost();
            
            // Fill form with data.
            $form->setData($data);
            if ($form->isValid()) {
                                
                // Get validated form data.
                $data = $form->getData();
                
                // Use post manager service update existing post.                
                $this->eventManager->editEvent($event, $data);
                
                // Redirect the user to "admin" page.
                return $this->redirect()->toRoute('event', ['action'=>'index']);
            }
        } else {
            $data = [
                'event_name' => $event->getEventName(),
                'event_description' => $event->getEventDescription(),
                'event_date' => $event->getEventDate(),
                'users_involved' => $event->getUsersInvolved(),  
            ];
            
            $form->setData($data);
        }
        
        // Render the view template.
        return new ViewModel([
            'form' => $form,
            'event' => $event
        ]);  
    }
    
    public function afficherMatiereNotEvaluateAction(){
        
        $id_classe = $_POST['classe'];
        $id_periode = $_POST['periode'];
        $id_annee = $_POST['annee'];
        
        $classe = $this->entityManager->getRepository(Classe::class)
               ->findOneById($id_classe);
        
        $periodeval = $this->entityManager->getRepository(Periodeval::class)
               ->findOneById($id_periode);
        
        $anneescolaire = $this->entityManager->getRepository(Anneescolaire::class)
               ->findOneById($id_annee);
        
        //$matieres = $this->entityManager->getRepository(Enseignee::class)
                //->findAllMatiereClasse($classe);
        
        $matieres = $this->entityManager->getRepository(Matiere::class)
                ->findAllMatiereNotEvaluate($id_classe, $id_periode, $id_annee);
        
        $eleves = $this->entityManager->getRepository(Eleve::class)
                ->findAllElevesClasse($classe);
        
        $request = $this->getRequest(); 
         if ($request->isXmlHttpRequest()) { 
           $jsonDataMatiere = array();
           $jsonDataEleve = array();
           $jsonData = array();
           $idx = 0;
           $idx2= 0;
           foreach($matieres  as $matiere) { 
              $temp =[
                 'id_enseignee' =>$matiere->getId(),
                 'libele' => $matiere->getLibeleMatiere(), 
                 'rang' => $matiere->getRangAsString(),
              ];  
             $jsonDataMatiere[$idx++] = $temp; 
           }
           foreach($eleves as $eleve){
                $temp2 =[
                 'id'=>$eleve->getId(),
                 'nom' => $eleve->getNomEleve(), 
                 'prenom' => $eleve->getPrenomEleve(), 
              ];  
             $jsonDataEleve[$idx2++] = $temp2;
           }
           $jsonData[0] = $jsonDataMatiere;
           $jsonData[1] = $jsonDataEleve;
           
           $view = new JsonModel($jsonData); 
           $view->setTerminal(true); 
          } else { 
             $view = new ViewModel(); 
        }  
       
      return $view;  
    }
    
    public function afficherPalmaresBulletinAction(){
         $id_classe = $_POST['classe'];
         $id_periode = $_POST['periode'];
       if ($id_classe<1) {
            $this->getResponse()->setStatusCode(404);
           return;
        }
        
        $periode = $this->entityManager->getRepository(Periodeval::class)
                ->findOneById($id_periode);
        
        $classe = $this->entityManager->getRepository(Classe::class)
                ->findOneById($id_classe);
        
        $eleves = $this->entityManager->getRepository(Eleve::class)
                ->findAllElevesNotesClasse($classe, $periode);
        
        
        $totalNote = array();
        $moyenne = array();
        $totalEleve = array();
        $note = 0;
        $i = 0;
        foreach($eleves  as $eleve) { 
          
           $evaluations = $this->entityManager->getRepository(Evaluation::class)
                ->findAllNotesEleve($eleve);
           $y = 0;
         foreach ($evaluations as $evaluation){
            
             $totalNote[$y]  = intval($evaluation->getNote());
             $y++; 
          } 
        $totalEleve[$i] = array_sum($totalNote);
         $moyenne[$i] = $this->evaluationManager->CalculerMoyenne($eleve, $id_classe);
        $i++;
       
        }
       $jsonDataEleves = array();
       
       $request = $this->getRequest(); 
         if ($request->isXmlHttpRequest()) { 
           
           $idx = 0;
            $y2 = 0;
           foreach($eleves  as $eleve) { 
              
              $temp =[
                 'id_eleve' =>$eleve->getId(),
                 'nom' => $eleve->getNomEleve(), 
                 'prenom' => $eleve->getPrenomEleve(),
                 'totalNote' => $totalEleve[$y2],
                 'moyenne' => $moyenne[$y2]
              ]; 
              $y2++;
             $jsonDataEleves[$idx++] = $temp; 
           }
           
          //$jsonData = array('id' => 'Success',); 
       $view = new JsonModel($jsonDataEleves); 
           $view->setTerminal(true);
      } else { 
             $view = new ViewModel(); 
        }
        return $view;
    }
    
    public function afficherMatiereClasseeAction(){
        $id_classe = $_POST['classe'];
        
        $classe = $this->entityManager->getRepository(Classe::class)
               ->findOneById($id_classe);
        
        $matieres = $this->entityManager->getRepository(Enseignee::class)
                ->findAllMatiereClasse($classe);
        
        $eleves = $this->entityManager->getRepository(Eleve::class)
                ->findAllElevesClasse($classe);
       
        $request = $this->getRequest(); 
         if ($request->isXmlHttpRequest()) { 
           $jsonDataMatiereEnseignee = array();
           $jsonDataEleve = array();
           $jsonData = array();
           $idx = 0;
           $idx2= 0;
           foreach($matieres  as $enseignee) { 
              $temp =[
                 'id_enseignee' =>$enseignee->getMatiere()->getId(),
                 'libele' => $enseignee->getMatiere()->getLibeleMatiere(), 
                 'rang' => $enseignee->getMatiere()->getRangAsString(), 
                 'coefficient' => $enseignee->getCoefficient(),
              ];  
             $jsonDataMatiereEnseignee[$idx++] = $temp; 
           }
           foreach($eleves as $eleve){
                $temp2 =[
                 'id'=>$eleve->getId(),
                 'nom' => $eleve->getNomEleve(), 
                 'prenom' => $eleve->getPrenomEleve(), 
              ];  
             $jsonDataEleve[$idx2++] = $temp2;
           }
           $jsonData[0] = $jsonDataMatiereEnseignee;
           $jsonData[1] = $jsonDataEleve;
           
           
           //$jsonData = array(
              // 'libele' => 'testok',
              // 'rang' => 'testok',
              // 'coefficient' => 'testok',
           //);
           $view = new JsonModel($jsonData); 
           $view->setTerminal(true); 
          } else { 
             $view = new ViewModel(); 
        }  
       
      return $view;
        
    }
    
     public function desaffecterAction()
    {
       $json_string = $_POST['matiere'];
       $enseignee = $this->entityManager->getRepository(Enseignee::class)
               ->findOneById($json_string);
       
       if ($enseignee == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        $this->enseigneeManager->deleteEnseignee($enseignee);
        
       $jsonData = array(
               'libele' => 'Test ok'
           );
            $view = new JsonModel($jsonData); 
          $view->setTerminal(true); 
        return $view;
    }
    
     public function confirmAction()
    {
      return new ViewModel();  
        
    }
    
    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        $event = $this->entityManager->getRepository(Event::class)
                ->find($id);
        
        if ($event == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Delete permission.
        $this->eventManager->deleteEvent($event);
        
        // Add a flash message.
        $this->flashMessenger()->addSuccessMessage('deleted successfully.');

        // Redirect to "confirm" page
        return $this->redirect()->toRoute('event', ['action'=>'confirm']); 
    }
    
   
    	
}