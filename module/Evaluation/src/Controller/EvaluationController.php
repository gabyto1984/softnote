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
Use Evaluation\Form\PalmaresbulletinsForm;
use Evaluation\Entity\Evaluation;
use Classe\Entity\ClasseEleves;
use Eleve\Entity\Eleve;
use Classe\Entity\Classe;
use Ecole\Entity\Ecole;
use Matiere\Entity\Matiere;
use Anneescolaire\Entity\Anneescolaire;
use Matiere\Entity\MatiereAffectee;
use Periodeval\Entity\Periodeval;
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
        $CurrentYear = 1;
        
        $classes = $this->entityManager->getRepository(Classe::class)
                ->findAllClassesHavingMatiere();
               
        $annee_scolaire = $this->entityManager->getRepository(Anneescolaire::class)
                ->findOneByStatut($CurrentYear);
        
        $matiere_affectee = $this->entityManager->getRepository(MatiereAffectee::class)
                ->findAllMatieresAffectees();
            
        return new ViewModel([
           'annee_scolaire' => $annee_scolaire,
           'classes' => $classes,
           'matieres_affectees' => $matiere_affectee
        ]);
      
    }
    
    public function eleveNonEvalueAction()
    {
        $id_classe = $_POST['classe'];
        $id_periode = $_POST['periodeval'];
        $id_matiere = $_POST['matiere'];
        
         $jsonData = array();
         $jsonDataEleve = array();
         $idx =0;
        
        $classe = $this->entityManager->getRepository(Classe::class)
               ->findOneById($id_classe);
        
        $periodeval = $this->entityManager->getRepository(Periodeval::class)
               ->findOneById($id_periode);
        
        $matiere = $this->entityManager->getRepository(MatiereAffectee::class)
               ->findOneById($id_matiere);
        
        $eleves = $this->entityManager->getRepository(Eleve::class)
               ->findAllEleveNonEvalue($classe, $periodeval, $matiere->getMatiere());
        
          foreach($eleves as $eleve){
                $temp =[
                 'id'=>$eleve->getId(),
                 'nom' => $eleve->getEleve()->getNomEleve(), 
                 'prenom' => $eleve->getEleve()->getPrenomEleve(), 
              ];  
             $jsonDataEleve[$idx++] = $temp;
           }
           $jsonData[0] = $jsonDataEleve; 
           $jsonData[1] = $matiere->getCoefficient();
           
        
       $view = new JsonModel($jsonData); 
           $view->setTerminal(true);
           
      return $view;
      /*
       $jsonData = array(
               'messagederetour' => 'Une nouvelle classe a été affecté',
              
           );
        
       $view = new JsonModel($jsonData); 
           $view->setTerminal(true);
           
      return $view;*/
    }
    
    
    
    public function palmaresAction(){
      
        // Create the form.
        $form = new PalmaresForm();
        
        $CurrentYear = 1;
        $periodeval = 0;
        
        $anneescolaire = $this->entityManager->getRepository(Anneescolaire::class)
                ->findOneByStatut($CurrentYear);
        if ($anneescolaire == null) {
            $this->getResponse()->setStatusCode(404);
            return;                        
        }
        
        foreach($this->entityManager->getRepository(Periodeval::class)->findByPeriodeForCurrentYear($CurrentYear) as $periodeval) {
        $optionsPeriode[$periodeval->getId()] = $periodeval->getDescription();
        }
        $form->get('periodeval')->setValueOptions($optionsPeriode);
        
        foreach($this->entityManager->getRepository(Classe::class)->findAllClassesHavingMatiere() as $classe) {
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
                ->findByElevesNotesClasse($classe, $periode);
        
        $totalNote = array();
        $moyenne = array();
        $totalEleve = array();
        $note = 0;
        $i = 0;
        foreach($eleves  as $eleve) { 
          
           $evaluations = $this->entityManager->getRepository(Evaluation::class)
                ->findAllNotesEleve($eleve, $classe, $periode);
           $y = 0;
         foreach ($evaluations as $evaluation){
            
             $totalNote[$y]  = intval($evaluation->getNote());
             $y++; 
          } 
        $totalEleve[$i] = array_sum($totalNote);
         $moyenne[$i] = $this->evaluationManager->CalculerMoyenne($eleve, $classe, $periode);
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
       $CurrentYear = 1;
       
        $classes = $this->entityManager->getRepository(Classe::class)
                ->findAllClassesHavingMatiere();
        
        $anneescolaire = $this->entityManager->getRepository(Anneescolaire::class)
                ->findOneByStatut($CurrentYear);
        
        $periodevals = $this->entityManager->getRepository(Periodeval::class)
                ->findByPeriodeForCurrentYear($CurrentYear);
        
        return new ViewModel([
            'classes' => $classes,
            'anneescolaire' =>  $anneescolaire,
            'periodevals' => $periodevals
        ]); 
    }
    
    public function palmaresbulletinsAction(){
        // Create the form.
        $form = new PalmaresbulletinsForm();
        
        //return false ;
        
        $CurrentYear = 1;
        $periodeval = 0;
        
        $anneescolaire = $this->entityManager->getRepository(Anneescolaire::class)
                ->findOneByStatut($CurrentYear);
        if ($anneescolaire == null) {
            $this->getResponse()->setStatusCode(404);
            return;                        
        }
        
        foreach($this->entityManager->getRepository(Periodeval::class)->findByPeriodeForCurrentYear($CurrentYear) as $periodeval) {
        $optionsPeriode[$periodeval->getId()] = $periodeval->getDescription();
        }
        $form->get('periodeval')->setValueOptions($optionsPeriode);
        
        foreach($this->entityManager->getRepository(Classe::class)->findAllClassesHavingMatiere() as $classe) {
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
                ->findByElevesNotesClasse($classe, $periode);
        
        $totalNote = array();
        $moyenne = array();
        $totalEleve = array();
        $note = 0;
        $i = 0;
        foreach($eleves  as $eleve) { 
          
           $evaluations = $this->entityManager->getRepository(Evaluation::class)
                ->findAllNotesEleve($eleve, $classe, $periode);
           $y = 0;
         foreach ($evaluations as $evaluation){
            
             $totalNote[$y]  = intval($evaluation->getNote());
             $y++; 
          } 
        $totalEleve[$i] = array_sum($totalNote);
         $moyenne[$i] = $this->evaluationManager->CalculerMoyenne($eleve, $classe, $periode);
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
         
         $this->ImprimerPalmares($anneescolaire->getId(), $periodeval, $classe->getId());
            
        return false;
         
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
    
    
    
    public function afficherPalmaresNotesAction()
    {
        $id_classe = $_POST['classe'];
        $id_periode = $_POST['periode'];
        $id_annee = $_POST['annee'];
        
        $classe = $this->entityManager->getRepository(Classe::class)
               ->findOneById($id_classe);
        
        $periodeval = $this->entityManager->getRepository(Periodeval::class)
               ->findOneById($id_periode);
        
        $allDisciplines = $this->entityManager->getRepository(Matiere::class)
                  ->findByDisciplinesHavingAnyMatieresEvalue($classe, $periodeval);
        
        $evaluations = $this->entityManager->getRepository(Evaluation::class)
                  ->findAllNotesPeriodeClasseEleves($classe, $periodeval);
        
        $eleves = $this->entityManager->getRepository(Eleve::class)
                ->findByElevesNotesClasse($classe, $periodeval);
        
        $request = $this->getRequest(); 
         if ($request->isXmlHttpRequest()) {
             
             $jsonDataMatiere = array();
             $jsonDataEleve = array();
             $jsonDataEleveNotes = array();
             $jsonData = array();
             $nbrmat = 0;
             $notes = array();
             $nbrel= 0;
             $i=0;
             $totalNote = array();
             $moyenne = array();
             $totalNotesEleve = array();
             
                foreach ($allDisciplines as $discipline){
                   foreach($discipline->getMatieres()  as $matiere) { 
                       $evaluation = $this->entityManager->getRepository(Evaluation::class)
                                          ->findEvalThisMatiere($matiere, $classe, $periodeval);
                       if($evaluation != null){
                       $matiere_affectee = $this->entityManager->getRepository(MatiereAffectee::class)
                                          ->findOneBy(array('matiere'=>$matiere, 'classe'=>$classe));
                      $temp =[
                         'id_enseignee' =>$matiere->getId(),
                         'libele' => $matiere->getLibeleMatiere(), 
                         'abrege' => $matiere->getAbrege(),
                         'rang' => $matiere->getRangAsString(),
                         'coef' => $matiere_affectee->getCoefficient(),
                          
                      ];  
                     $jsonDataMatiere[$nbrmat++] = $temp; 
                    }
                   }
                }
                             
                
              $ne=0;  $y2=0;
           foreach($eleves as $eleve){
             $y=0;
              //$jsonDataEleveNotes[$i]= $temp2;
               
                  //$matiere = $this->entityManager->getRepository(Matiere::class)->findOneById($jsonDataMatiere[$i]['id_enseignee']);
                  $evaluations = $this->entityManager->getRepository(Evaluation::class)
                          ->findNotes($eleve, $classe, $periodeval);
                  //$evaluationsNotes = $this->entityManager->getRepository(Evaluation::class)
                           //->findAllNotesEleve($eleve);
                    $z =0;
                  foreach($evaluations as $evaluation){
                      $temp3 =[
                          'id'=>$evaluation->getId(),
                          'note'=> $evaluation->getNote(),
                          
                      ];
                     $jsonDataEleveNotes[$ne][$y] = $temp3;
                     $totalNote[$z]  = intval($evaluation->getNote());
             
                  $y++;  $z++; 
                }
               $totalNotesEleve[$i] = array_sum($totalNote);
              $moyenne[$i] = $this->evaluationManager->CalculerMoyenne($eleve, $classe, $periodeval);
            
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
             
             
             $jsonData[0] =$jsonDataMatiere;
             $jsonData[1] =$jsonDataEleve;
             $jsonData[2]= $jsonDataEleveNotes;
          //$jsonData = array(
             // 'resultat' => 'testok',);           
           $view = new JsonModel($jsonData); 
           $view->setTerminal(true);    
         }else { 
             $view = new ViewModel(); 
        }  
       
      return $view;  
        
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
                  ->findByDisciplinesHavingAnyMatieresEvalue($classe, $periodeval);
      
        $eleves = $this->entityManager->getRepository(Eleve::class)
                ->findByElevesNotesClasse($classe, $periodeval);
       
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
                
                  //$matiere = $this->entityManager->getRepository(Matiere::class)->findOneById($jsonDataMatiere[$i]['id_enseignee']);
                  $evaluations = $this->entityManager->getRepository(Evaluation::class)
                          ->findNotes($eleve, $classe, $periodeval);
                  //$evaluationsNotes = $this->entityManager->getRepository(Evaluation::class)
                           //->findAllNotesEleve($eleve);
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
         /*
             $temp2 =[
                 'id'=>$eleve->getId(),
                 'nom' => $eleve->getNomEleve(), 
                 'prenom' => $eleve->getPrenomEleve(),
                 'totalNote' => $totalNotesEleve[$y2],
                 'moyenne' => $moyenne[$y2]
              ];  
             
             $jsonDataEleve[$nbrel++] = $temp2;
             
             $i++; $ne++; $y2++;*/
           }
           
             
             
           $jsonData[0] = $jsonDataMatiere;
           $jsonData[1] =$jsonDataEleve;
           $jsonData[2]= $jsonDataEleveNotes;
           //
            $jsonData = array(
              'resultat' => 'testok',
           );
           
           
           $view = new JsonModel($jsonData); 
           $view->setTerminal(true); 
          } else { 
             $view = new ViewModel(); 
        }  
       
      return $view;      
    }
    
    public function modifierNoteAction()
    {
        $id_evaluation = $_POST['id_evaluation'];
        $nouvelle_note = $_POST['nouvelle_note'];
        
       $evaluation = $this->entityManager->getRepository(Evaluation::class)
               ->findOneById($id_evaluation);
       
       if ($evaluation == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        $this->evaluationManager->modifierNote($evaluation, $nouvelle_note);
        
       $jsonData = array(
               'resultat' => 'Modification réussie'
           );
            $view = new JsonModel($jsonData); 
          $view->setTerminal(true); 
        return $view;
    }
    
    
    public function imprimerPalmaresAction()
    {
      $id_eleve = (int)$this->params()->fromRoute('id', -1);
      $id_classe = (int)$this->params()->fromRoute('classe', -1);
      $id_periode = (int)$this->params()->fromRoute('periode', -1);
        
      //$ecole = $this->entityManager->getRepository(Ecole::class)->findAll();
      $ecole_id = $this->entityManager->getRepository(Ecole::class)
                              ->findBy(array(), array('id' => 'desc'),1,0); 
               foreach ($ecole_id as $ecoles){
                $idEcole = $ecoles->getId();
                    }
       $ecole = $this->entityManager->getRepository(Ecole::class)->findOneById($idEcole); 
      
        return false;
    }
    
    public function ImprimerPalmares($annee, $periode, $classe)
    {
        $id_classe = $classe;
        $id_periode = $periode;
        $id_annee = $annee;
        
        $classe = $this->entityManager->getRepository(Classe::class)
               ->findOneById($id_classe);
        
        $periodeval = $this->entityManager->getRepository(Periodeval::class)
               ->findOneById($id_periode);
        
        $allDisciplines = $this->entityManager->getRepository(Matiere::class)
                  ->findByDisciplinesHavingAnyMatieresEvalue($classe, $periodeval);
        
        $evaluations = $this->entityManager->getRepository(Evaluation::class)
                  ->findAllNotesPeriodeClasseEleves($classe, $periodeval);
        
        $eleves = $this->entityManager->getRepository(Eleve::class)
                ->findByElevesNotesClasse($classe, $periodeval);
        
        //$ecole = $this->entityManager->getRepository(Ecole::class)->findAll();
        $ecole_id = $this->entityManager->getRepository(Ecole::class)
                              ->findBy(array(), array('id' => 'desc'),1,0); 
               foreach ($ecole_id as $ecoles){
                $idEcole = $ecoles->getId();
                    }
        $ecole = $this->entityManager->getRepository(Ecole::class)->findOneById($idEcole); 
    
        
        
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->SetTitle('Palmares bulletins');
             
            $pdf->AddPage();
            $pdf->setFormDefaultProp(array('lineWidth'=>1, 'borderStyle'=>'solid', 'fillColor'=>array(255, 255, 200), 'strokeColor'=>array(255, 128, 128)));
            // Image example with resizing
            $pdf->Image('public'.$ecole->getLogo(), 15, 27, 30, 15, 'PNG', 'http://www.softnote.com', '', true, 150, '', false, false, 0, false, false, false);
            $pdf->SetFont('helvetica', 'BI', 12);
            $pdf->Ln(5);
            $pdf->Cell(0, 4, 'Palmares bulletins'.'   année:  '.$periodeval->getAnneeScolaire()->getLibele(), 0, 1, 'C');
            $pdf->Ln(7);
            $pdf->SetFont('helvetica', '', 8);
            $pdf->Cell(35, 2, '', 0, 0, 'C');
            $pdf->Cell(50, 2, $ecole->getNom(), 0, 0, 'L');
            $pdf->SetFont('helvetica', '', 10);
            $date1 = date('Y-m-d');
               setlocale(LC_TIME, "fr_FR","French");
            $date = strftime("%d %B %Y", strtotime($date1));
            $pdf->Cell(30, 2, 'Date d\'émission', 0, 0, 'C');
            $pdf->Cell(40, 2, ''.$date.'', 0, 0, 'C');
            $pdf->Ln(3.5);
            $pdf->SetFont('helvetica', '', 8);
            $pdf->Cell(35, 2, '', 0, 0, 'C');
            $pdf->Cell(50, 2, $ecole->getAdresse(), 0, 0, 'L');
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(30, 2, '', 0, 0, 'C');
            $pdf->Cell(40, 2, '', 0, 0, 'C');
            $pdf->Ln(3.5);
            $pdf->SetFont('helvetica', '', 8);
            $pdf->Cell(35, 2, '', 0, 0, 'C');
            $pdf->Cell(50, 2, $ecole->getEmail(), 0, 0, 'L');
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(30, 2, '', 0, 0, 'C');
            $pdf->Cell(40, 2, '', 0, 0, 'C');
            $pdf->Ln(3.5);
            $pdf->SetFont('helvetica', '', 8);
            $pdf->Cell(35, 2, '', 0, 0, 'C');
            $pdf->Cell(50, 2, $ecole->getTelephones(), 0, 0, 'L');
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(30, 2, ''.$classe->getLibele().'', 0, 0, 'C');
            $pdf->Cell(40, 2, ''.$periodeval->getDescription().'', 0, 0, 'C');
           
            $pdf->Ln(30);
            //Background color of header//
            //$pdf->Cell(30,7,'',1,1,'C',true);
            $pdf->SetFillColor(193,229,252);
            $pdf->Cell(30,5,'Nom&Prenom',1,0,'C',true);
            $nm = 0;
            $i = 0;
            foreach ($allDisciplines as $discipline){
                   foreach($discipline->getMatieres()  as $matiere) {
                       $evaluation = $this->entityManager->getRepository(Evaluation::class)
                                          ->findEvalThisMatiere($matiere, $classe, $periodeval);
                       if($evaluation != null){
                      // $nbmat = count($matiere);
                       $matiere_affectee = $this->entityManager->getRepository(MatiereAffectee::class)
                                          ->findOneBy(array('matiere'=>$matiere, 'classe'=>$classe));
                      $temp =[
                         'id_enseignee' =>$matiere->getId(),
                         'libele' => $matiere->getLibeleMatiere(), 
                         'abrege' => $matiere->getAbrege(),
                         'rang' => $matiere->getRangAsString(),
                         'coef' => $matiere_affectee->getCoefficient(),
                          
                      ];
                     
                      $pdf->SetXY(42.5+$i,70);
                      $pdf->StartTransform();
                      $pdf->Rotate(65);
                      $pdf->Cell(30,5,$matiere->getLibeleMatiere(),1,0,'L',0,false);
                      $pdf->StopTransform();
                      
                      $i = $i + 10;
                      $nm ++;
                    } 
                   }
            }
            $pdf->SetXY(42.5+$i,70);
            $pdf->StartTransform();
            $pdf->Rotate(65);
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(30,5,'Total Note',1,0,'L',0,false);
            $pdf->StopTransform();   
            $pdf->Ln(-2.3);
            //$pdf->Cell(0,-5,'',0,1);
            $pdf->Cell(0,5,'',0,1);
            $pdf->SetFont('helvetica', '', 10);
            $jsonDataEleveNotes = array();
            $ne=0; $n= 0;
             foreach ($eleves as $eleve){
                //$pdf->Cell(30,5,'Nom&Prenom',1,0,'C',true); 
                 $pdf->SetFont('helvetica', '', 8);
                $pdf->Cell(30,5,$eleve->getNomEleve().','.$eleve->getPrenomEleve(),1,0,'C');
                  $y = 0; $z = 0; 
                foreach ($this->entityManager->getRepository(Evaluation::class)->findAllNotesEleve($eleve, $classe, $periodeval) as $eval){
                   
                   $temp3 =[
                          'note'=> $eval->getNote(),
                      ];
                     $jsonDataEleveNotes[$ne][$y] = $temp3;
                     $totalNote[$z]  = intval($eval->getNote());
             
                   $y++; $z++;
                    }
                $totalNotesEleve[$n] = array_sum($totalNote);
                $nn = count($jsonDataEleveNotes);
                for ($i=0; $i<$nm; $i++){
                $pdf->Cell(10,5,$jsonDataEleveNotes[$ne][$i]['note'],1,0,'C');
                //$pdf->Cell(10,5,'10.50',1,0,'C');
                }
                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->Cell(10,5,$totalNotesEleve[$n],1,0,'C');
                $pdf->Cell(0,5,'',0,1);
               
                $ne++; $n++;
             }
            
            $pdf->endPage();
            $pdf->lastPage();
            $pdf->Output('I');
    }
    
    
    public function imprimerAction(){
    
      //Les variables passees en parametre depuis la vue palmares
      $id_eleve = (int)$this->params()->fromRoute('id', -1);
      $id_classe = (int)$this->params()->fromRoute('classe', -1);
      $id_periode = (int)$this->params()->fromRoute('periode', -1);
      
      //Des variables declaree
     
      $totalNote = array();
      $minTotalNote = array();
      $totalMinNoteClasse= array();
      $totalMaxNoteClasse= array();
      $totalMoyenne = array();
      $totalNoteDisc = array();

      
      //Si l'id de l'eleve est nul
            if ($id_eleve<1) {
                $this->getResponse()->setStatusCode(404);
                  return;
             }
      //Differents objets de donnees qu'on va utiliser
      $periodeval = $this->entityManager->getRepository(Periodeval::class)->findOneById($id_periode);
      
      $classe = $this->entityManager->getRepository(Classe::class)->findOneById($id_classe);
      
      $eleve = $this->entityManager->getRepository(Eleve::class)->findOneById($id_eleve);
     
      $allDiscipline = $this->entityManager->getRepository(Matiere::class)->findByDisciplinesHavingAnyMatieresEvalue($classe, $periodeval);
     
      //$ecole = $this->entityManager->getRepository(Ecole::class)->findAll();
      $ecole_id = $this->entityManager->getRepository(Ecole::class)
                              ->findBy(array(), array('id' => 'desc'),1,0); 
               foreach ($ecole_id as $ecoles){
                $idEcole = $ecoles->getId();
                    }
       $ecole = $this->entityManager->getRepository(Ecole::class)->findOneById($idEcole); 
      //$evaluations = $this->entityManager->getRepository(Evaluation::class)->findAllNotesEleve($eleve, $classe, $periodeval);
    
      
      //Creation de la page PDF
     $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
         $pdf->SetCreator(PDF_CREATOR);
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->SetTitle('Bulletin Scolaire');
             
            $pdf->AddPage();
            $pdf->setFormDefaultProp(array('lineWidth'=>1, 'borderStyle'=>'solid', 'fillColor'=>array(255, 255, 200), 'strokeColor'=>array(255, 128, 128)));
            // Image example with resizing
            $pdf->Image('public'.$ecole->getLogo(), 15, 27, 30, 15, 'PNG', 'http://www.softnote.com', '', true, 150, '', false, false, 0, false, false, false);
   
            $pdf->SetFont('helvetica', 'BI', 12);
            $pdf->Ln(5);
            $pdf->Cell(0, 4, 'Bulletin Scolaire'.'   année:  '.$periodeval->getAnneeScolaire()->getLibele(), 0, 1, 'C');
            $pdf->Ln(7);
            $pdf->SetFont('helvetica', '', 8);
            $pdf->Cell(35, 2, '', 0, 0, 'C');
            $pdf->Cell(50, 2, $ecole->getNom(), 0, 0, 'L');
            $pdf->SetFont('helvetica', '', 10);
            $date1 = date('Y-m-d');
               setlocale(LC_TIME, "fr_FR","French");
            $date = strftime("%d %B %Y", strtotime($date1));
            $pdf->Cell(30, 2, 'Date d\'émission', 0, 0, 'C');
            $pdf->Cell(40, 2, ''.$date.'', 0, 0, 'C');
            $pdf->Ln(3.5);
            $pdf->SetFont('helvetica', '', 8);
            $pdf->Cell(35, 2, '', 0, 0, 'C');
            $pdf->Cell(50, 2, $ecole->getAdresse(), 0, 0, 'L');
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(30, 2, '', 0, 0, 'C');
            $pdf->Cell(40, 2, '', 0, 0, 'C');
            $pdf->Ln(3.5);
            $pdf->SetFont('helvetica', '', 8);
            $pdf->Cell(35, 2, '', 0, 0, 'C');
            $pdf->Cell(50, 2, $ecole->getEmail(), 0, 0, 'L');
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(30, 2, '', 0, 0, 'C');
            $pdf->Cell(40, 2, '', 0, 0, 'C');
            $pdf->Ln(3.5);
            $pdf->SetFont('helvetica', '', 8);
            $pdf->Cell(35, 2, '', 0, 0, 'C');
            $pdf->Cell(50, 2, $ecole->getTelephones(), 0, 0, 'L');
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(30, 2, ''.$classe->getLibele().'', 0, 0, 'C');
            $pdf->Cell(40, 2, ''.$periodeval->getDescription().'', 0, 0, 'C');
            
            
            $pdf->Ln(10);
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(100, 4, 'Nom:'.$eleve->getNomEleve().'', 0, 0, 'C');
            $pdf->Cell(40, 4, 'Prénom:'.$eleve->getPrenomEleve().'', 0, 0, 'C');
            $pdf->Ln(10);
             //$width_cell=array(40,40,40,70);
            $pdf->SetFont('helvetica','B',10);

            //Background color of header//
            $pdf->SetFillColor(193,229,252);
                
            $pdf->Cell(30,9.5,'Matières',1,0,'C',true);
            $pdf->Cell(40,5,'Moyennes',1,0,'C',true);
            $pdf->Cell(40,5,'Notes extrêmes',1,0,'C',true);
            $pdf->Cell(80,9.5,'Appréciations générales',1,0,'C',true);
            $pdf->Cell(0,5,'',0,1);
            
            $pdf->SetFont('helvetica','',10);
            $pdf->Cell(30,4,'',0,0);
            $pdf->Cell(20,4,'Elève',1,0,true);
            $pdf->Cell(20,4,'Classe',1,0,true);
            $pdf->Cell(20,4,'Min',1,0,true);
            $pdf->Cell(20,4,'Max',1,1,true);
            
            $z = 0;  $s=0; $nbrDisc =0; $nbrEval =0; $i=0;
       foreach ($allDiscipline as $discipline) {
            //$nbrDisc = count($discipline);
            $totalCoefParDiscipline = $this->evaluationManager->CalculerTotalCoefParDiscipline($discipline, $classe, $periodeval); 
            $totalNoteParDiscipline = $this->evaluationManager->CalculerTotalNoteParDiscipline($eleve, $discipline, $classe, $periodeval);
            $NoteParDisciplineClasse = $this->evaluationManager->CalculerNoteParDisciplineClasse($discipline, $classe, $periodeval);
            $nb_eleve_evalue = $this->evaluationManager->CalculerQuantiteEleveEvalue($classe, $periodeval);
            $minimumNoteDisciplineClasse = $this->evaluationManager->CalculerMinimumNoteParDisciplineClasse($discipline, $classe, $periodeval);
            $maximumNoteDisciplineClasse = $this->evaluationManager->CalculerMaximumNoteParDisciplineClasse($discipline, $classe, $periodeval);
            $NEPD = round($totalNoteParDiscipline, 2);
            $NCPD = round(($NoteParDisciplineClasse/$nb_eleve_evalue), 2);
            $MIN_NED = round($minimumNoteDisciplineClasse, 2);
            $MAX_NED = round($maximumNoteDisciplineClasse, 2);
            $aprec ='';
            
            $pdf->SetFont('helvetica','BI',10);
            $pdf->Cell(30,5,$discipline->getAbrege(),1,0,'L');
            $pdf->Cell(20,5,round($totalNoteParDiscipline, 2).'/'.$totalCoefParDiscipline,1,0,'C');
            $pdf->Cell(20,5,round(($NoteParDisciplineClasse/$nb_eleve_evalue), 2).'/'.$totalCoefParDiscipline,1,0,'C');
            $pdf->SetFont('helvetica','BI',10);
            $pdf->Cell(20,5,round($minimumNoteDisciplineClasse, 2).'/'.$totalCoefParDiscipline,1,0,'C');
            $pdf->Cell(20,5,round($maximumNoteDisciplineClasse, 2).'/'.$totalCoefParDiscipline,1,0,'C');
            $pdf->SetFont('helvetica','',9);
            
            $pdf->Cell(80,5,$aprec,1,1,'C');
            $y = 0;  
               foreach ($this->entityManager->getRepository(Evaluation::class)->findAllNotesEleveByDiscipline($eleve, $discipline, $classe, $periodeval) as $eval){
                   //$nbreval = count($eval); 
                   $totalNotesClasse = $this->evaluationManager->CalculerTotalNoteClasse($eval->getMatiereAffectee()->getMatiere(), $classe, $periodeval);
                   $minimumNotesClasse = $this->evaluationManager->CalculerMinimumNoteClasse($eval->getMatiereAffectee()->getMatiere(), $classe, $periodeval);
                   $maximumNotesClasse = $this->evaluationManager->CalculerMaximumNoteClasse($eval->getMatiereAffectee()->getMatiere(), $classe, $periodeval);
                   $minTotalNote[$y] = $minimumNotesClasse;
                   $NOTE_E = $eval->getNote();
                   $MAX_NOTE_CLA = round($maximumNotesClasse, 2);
                   $MIN_NOTE_CLA = round($minimumNotesClasse, 2);
                    $pdf->SetFont('helvetica','',10);
                    $pdf->Cell(30,5,'-'.$eval->getMatiereAffectee()->getMatiere()->getAbrege(),1,0,'L');
                    $pdf->Cell(20,5,$eval->getNote().'/'.$eval->getMatiereAffectee()->getCoefficient(),1,0,'C');
                    $pdf->Cell(20,5,round($totalNotesClasse, 2).'/'.$eval->getMatiereAffectee()->getCoefficient(),1,0,'C');
                    $pdf->Cell(20,5,round($minimumNotesClasse, 2),1,0,'C');
                    $pdf->Cell(20,5,round($maximumNotesClasse, 2),1,0,'C');
                    $pdf->SetFont('helvetica','',9);
                     if($NOTE_E == $MAX_NOTE_CLA & round(($MAX_NOTE_CLA*100)/$totalNotesClasse, 2)>80){
                        $aprec = 'Excellent, tu as la meilleure note de la classe !';  
                      }elseif($NOTE_E == $MIN_NOTE_CLA & $NOTE_E != 0){
                         $aprec = 'Très mal, tu as la note la plus petite de la classe';   
                      }elseif($NOTE_E == 0){
                         $aprec = 'L\'élève était absent, ou il l\'a raté';   
                      }elseif($NOTE_E < $MAX_NOTE_CLA & $NOTE_E < round((($MIN_NOTE_CLA + $MAX_NOTE_CLA)/2), 2)){
                         $aprec = 'Bien, mais il faut s\'investir davantage !';   
                      }elseif($NOTE_E < $MAX_NOTE_CLA & $NOTE_E > round((($MIN_NOTE_CLA + $MAX_NOTE_CLA)/2), 2)){
                         $aprec = 'Très bien, mais l\'élève peut faire mieux !';   
                      }elseif($NOTE_E < round((($MIN_NOTE_CLA + $MAX_NOTE_CLA)/2), 2) & $NOTE_E < ($totalNotesClasse/2) & $NOTE_E != 0){
                         $aprec = 'Très faible, beaucoup d\'efforts !';   
                      }
                    $pdf->Cell(80,5,$aprec,1,1,'C');
                    
                          $totalMoyenne[$s] = $totalNotesClasse;
                          $totalNote[$y]  = intval($eval->getNote());
                          $totalMinNoteClasse[$s] =$minimumNotesClasse; 
                          $totalMaxNoteClasse[$s] =$maximumNotesClasse;
                          $totalNoteDisc[$y] = intval($eval->getMatiereAffectee()->getCoefficient());
                           $y++; $s++;
                     $nbrEval = $y+1;
               }
              $i++;
               $nbrDisc = $i+1;          
            }
            $z++;
            $totalNotesMoyenne = array_sum($totalMoyenne);
            $moyenneNotesEleve = $this->evaluationManager->CalculerMoyenne($eleve, $classe, $periodeval);
            $totalCoefficient = $this->evaluationManager->CalculerTotalCoef($classe, $periodeval); 
            $totalNotesEleve = $this->evaluationManager->CalculerTotalNote($eleve, $classe, $periodeval);
            //$totalNotesClasse = $this->evaluationManager->CalculerTotalNoteClasse($classe, $periodeval);
            
            $totalMinNoteClasse2 = array_sum($totalMinNoteClasse);
            $totalMaxNoteClasse2 = array_sum($totalMaxNoteClasse);
            $pdf->SetFont('helvetica','B',10);
            $pdf->Cell(30,6,'Total',1,0,'C',true);
            $pdf->Cell(20,6,round($totalNotesEleve, 2).'/'.$totalCoefficient,1,0,'C',true);
            $pdf->Cell(20,6,round($totalNotesMoyenne, 2).'/'.$totalCoefficient,1,0,'C',true);
            $pdf->Cell(20,6,round($totalMinNoteClasse2, 2).'/'.$totalCoefficient,1,0,'C',true);
            $pdf->Cell(20,6,round($totalMaxNoteClasse2, 2).'/'.$totalCoefficient,1,0,'C',true);
            $pdf->Cell(80,6,'',1,0,'C',true);
            $pdf->Cell(0,5,'',0,1);
            $MOY_EL = round(($totalNotesEleve*10)/$totalCoefficient, 2);
            $aprecm = '';
            
            $pdf->SetFont('helvetica','B',10);
            $pdf->Cell(30,6,'Moyenne',1,0,'C',true);
            $pdf->Cell(20,6,round(($totalNotesEleve*10)/$totalCoefficient, 2).'/10',1,0,'C',true);
            $pdf->Cell(20,6,round(($totalNotesMoyenne*10)/$totalCoefficient, 2).'/10',1,0,'C',true);
            $pdf->Cell(20,6,round(($totalMinNoteClasse2*10)/$totalCoefficient, 2).'/10',1,0,'C',true);
            $pdf->Cell(20,6,round(($totalMaxNoteClasse2*10)/$totalCoefficient, 2).'/10',1,0,'C',true);
            $pdf->SetFont('helvetica','B',9);
                 if($MOY_EL > 4.99 & $MOY_EL < 6){
                        $aprecm = 'Réussite de justesse';  
                      }elseif($MOY_EL > 5.99 &  $MOY_EL < 7){
                         $aprecm = 'Acceptable, il faut s\'investir davantage';   
                      }elseif($MOY_EL > 6.99 &  $MOY_EL < 8){
                         $aprecm = 'Très bien, mais tu peux faire mieux';   
                      }elseif($MOY_EL > 7.99 &  $MOY_EL < 9){
                         $aprecm = 'Excellent resultat, continu ainsi';   
                      }elseif($MOY_EL > 8.99 &  $MOY_EL <= 10){
                         $aprecm = 'Parfait !, exceptionnelle';   
                      }   
             
            
            $pdf->Cell(80,6,$aprecm,1,0,'C',true);
            $pdf->SetFont('helvetica','B',10);  
            $pdf->Cell(0,5,'',0,1);
            $pdf->Ln(20);
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(140, 4, 'Moyenne :', 0, 0, 'R');
            $pdf->Cell(20, 4, $MOY_EL.'/10', 0, 0, 'C');
            $pdf->Ln(5);
            $pdf->Cell(140, 4, 'Position:', 0, 0, 'R');
            $pdf->Cell(20, 4, $this->calculerPosition($eleve, $classe, $periodeval), 0, 0, 'C');
            $pdf->Ln(5);
            $pdf->Cell(140, 4, 'Mention :', 0, 0, 'R');
            $pdf->Cell(20, 4, $this->mention($MOY_EL), 0, 0, 'C');
            $pdf->Ln(40);
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(110, 4, '__________________', 0, 0, 'C');
            $pdf->Cell(40, 4, '______________', 0, 0, 'C');
            $pdf->Ln(4);
            $pdf->Cell(110, 4, 'Parent de l\'élève', 0, 0, 'C');
            $pdf->Cell(40, 4, 'La diréction', 0, 0, 'C');
            $pdf->SetFont('helvetica', '', 12);
            $posy = (($nbrDisc+$nbrEval)*5)+80;
             if($periodeval->getPeriode()->getType()== 1){
                 
                 $this->dessinerChart($pdf, $posy);
            $pdf->SetFont('helvetica','B',10);  
            $pdf->Cell(0,5,'',0,1);
            $pdf->Ln(20);
                       
             }
            //$pdf->Cell(80,6,$aprecm,1,0,'C',true);
            
           
            $pdf->endPage();
            $pdf->lastPage();
            $pdf->Output('I');
           
        return false;
        
    }
    public function mention($moy_elev){
        if($moy_elev >5){
            return 'Réussi(e)';
        }else{
            return 'Echoué(e)';
        }
    }
    
    public function calculerPosition($eleve, $classe, $periodeval)
    {
        $positionEleve = $this->evaluationManager->CalculerPosition($eleve, $classe, $periodeval);
    
        return $positionEleve;
    }
    
    public function dessinerChart($pdf, $posy){
        // Chart properties
        //position
        $chartx = 20;
        $charty = $posy;
        
        //dimenssion
        $chartWidth = 100;
        $chartHeight =50;
        
        //padding
        $chartTopPadding = 10;
        $chartLeftPadding = 5;
        $chartBottomPadding = 10;
        $chartRightPadding = 5;
        
        //chartBox
        $chartBoxX = $chartx + $chartLeftPadding;
        $chartBoxY = $charty + $chartTopPadding;
        $chartBoxWidth = $chartWidth - $chartLeftPadding - $chartRightPadding;
        $chartBoxHeight = $chartHeight - $chartTopPadding - $chartBottomPadding;
        
        $barWidth = 20;
        
        //Chart data
        $data = Array(
            'Contr. 1'=>[
              'color'=>[255, 0, 0],
                'value'=>100
            ],
            'Contr. 2'=>[
              'color'=>[255, 255, 0],
                'value'=>200
            ],
            'Contr. 3'=>[
              'color'=>[50, 0, 255],
                'value'=>70
            ],
            'Contr. 4'=>[
              'color'=>[255, 0, 255],
                'value'=>25
            ],
        );
        
        $dataMax = 0;
        
        foreach($data as $item){
            if($item['value']> $dataMax )
                $dataMax = $item['value'];
        }
        
        $dataStep = 50;
        
        //$pdf->Cell(0,5,'',0,1);
        //$pdf->Ln(20);
        $pdf->SetFont('helvetica','',10);
        $pdf->SetLineWidth(0.2);
        $pdf->SetDrawColor(0);
        //$pdf->Rect($chartx, $charty, $chartWidth, $chartHeight);
       
        //vertical axe line
        $pdf->Line(
          $chartBoxX,
          $chartBoxY,
          $chartBoxX,
          $chartBoxY+$chartBoxHeight    
                );
        
        //horizontal 
        $pdf->Line(
          $chartBoxX-2,
          $chartBoxY+$chartBoxHeight,
          $chartBoxX+$chartBoxWidth,
          $chartBoxY+$chartBoxHeight    
                );
        
        //vertical axis
        //calculate cghart's y axis scale unit
        $yAxisUnits = $chartBoxHeight / $dataMax;
        
        //draw the vertical (y) axis labels
        
        for($i=0; $i<=$dataMax; $i+=$dataStep){
            // y position
            $yAxisPos=$chartBoxY + ($yAxisUnits * $i);
            
            //draw y axis lines 
            $pdf->Line(
                    $chartBoxX-2,
                    $yAxisPos,
                    $chartBoxX,
                    $yAxisPos
                    );
            //set cell position for y axis labels
            $pdf->SetXY($chartBoxX - $chartLeftPadding, $yAxisPos-2);
            $pdf->Cell($chartLeftPadding-4,5,$dataMax-$i,0,0,'R');
        }
        //horizontal axis
        //set cell position
        $pdf->SetXY($chartBoxX,$chartBoxY+$chartBoxHeight);
        
        //cell's width
        $xLabelWidth=$chartBoxWidth / count($data);
        
        //loop horizontal axis and draw the bar
        $barXPos=0;
        foreach($data as $itemName=>$item){
          //print the label
           $pdf->Cell($xLabelWidth,5,$itemName,0,0,'C');
           //drawing the bar
           //bar color
           $pdf->SetFillColor($item['color'][0],$item['color'][1],$item['color'][2]);
           //bar height
           $barHeight=$yAxisUnits*$item['value'];
           //bar x position
           $barX=($xLabelWidth/2)+($xLabelWidth*$barXPos);
           $barX=$barX-($barWidth/2);
           $barX=$barX+$chartBoxX;
           
           //bar y position
           $barY=$chartBoxHeight-$barHeight;
           $barY=$barY+$chartBoxY;
           //draw the bar
           $pdf->Rect($barX, $barY, $barWidth, $barHeight, 'DF');
           //increment $barxPos
           $barXPos++;
        }
        //axis labels
        $pdf->SetFont('helvetica','B',10);
        $pdf->SetXY($chartx,$charty);
        $pdf->Cell(100,10,"Moyenne");
        $pdf->SetXY(($chartWidth/2)-50+$chartx, $charty+$chartHeight-($chartBottomPadding/2));
        $pdf->Cell(100,10,"Periodes des controles decisionnels",0,0,'C');
    }
    
   
    
     public function imprimerTousAction(){
               
      $id_classe = (int)$this->params()->fromRoute('classe', -1);
      $id_periode = (int)$this->params()->fromRoute('periode', -1);
      
      //Des variables declaree
      $totalNotesEleve = 0;
      $moyenneNotesEleve = 0;
      $totalNote = array();
      $minTotalNote = array();
      $totalMinNoteClasse= array();
      $totalMaxNoteClasse= array();
      $totalMoyenne = array();
      $totalNoteDisc = array();
    
     
      //Differents objets de donnees qu'on va utiliser
      $periodeval = $this->entityManager->getRepository(Periodeval::class)->findOneById($id_periode);
      
      $classe = $this->entityManager->getRepository(Classe::class)->findOneById($id_classe);
      
      $eleves = $this->entityManager->getRepository(Eleve::class)->findByElevesNotesClasse($classe, $periodeval);
      
      $allDiscipline = $this->entityManager->getRepository(Matiere::class)->findByDisciplinesHavingAnyMatieresEvalue($classe, $periodeval);
     
      $ecole_id = $this->entityManager->getRepository(Ecole::class)
                              ->findBy(array(), array('id' => 'desc'),1,0); 
               foreach ($ecole_id as $ecoles){
                $idEcole = $ecoles->getId();
                    }
      $ecole = $this->entityManager->getRepository(Ecole::class)->findOneById($idEcole); 
    
      //Creation de la page PDF
     $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
         $pdf->SetCreator(PDF_CREATOR);
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->SetTitle('Bulletin Scolaire');
            
            
     foreach($eleves as $eleve)
     {       
            //$eleve =  $this->entityManager->getRepository(Eleve::class)->findOneById($id_eleve);
            $pdf->AddPage();
            $pdf->setFormDefaultProp(array('lineWidth'=>1, 'borderStyle'=>'solid', 'fillColor'=>array(255, 255, 200), 'strokeColor'=>array(255, 128, 128)));
            // Image example with resizing
            $pdf->Image('public'.$ecole->getLogo(), 15, 27, 30, 15, 'PNG', 'http://www.softnote.com', '', true, 150, '', false, false, 0, false, false, false);
   
            $pdf->SetFont('helvetica', 'BI', 12);
            $pdf->Ln(5);
            $pdf->Cell(0, 4, 'Bulletin Scolaire'.'   année:  '.$periodeval->getAnneeScolaire()->getLibele(), 0, 1, 'C');
            $pdf->Ln(7);
            $pdf->SetFont('helvetica', '', 8);
            $pdf->Cell(35, 2, '', 0, 0, 'C');
            $pdf->Cell(50, 2, $ecole->getNom(), 0, 0, 'L');
            $pdf->SetFont('helvetica', '', 10);
            $date1 = date('Y-m-d');
               setlocale(LC_TIME, "fr_FR","French");
            $date = strftime("%d %B %Y", strtotime($date1));
            $pdf->Cell(30, 2, 'Date d\'émission', 0, 0, 'C');
            $pdf->Cell(40, 2, ''.$date.'', 0, 0, 'C');
            $pdf->Ln(3.5);
            $pdf->SetFont('helvetica', '', 8);
            $pdf->Cell(35, 2, '', 0, 0, 'C');
            $pdf->Cell(50, 2, $ecole->getAdresse(), 0, 0, 'L');
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(30, 2, '', 0, 0, 'C');
            $pdf->Cell(40, 2, '', 0, 0, 'C');
            $pdf->Ln(3.5);
            $pdf->SetFont('helvetica', '', 8);
            $pdf->Cell(35, 2, '', 0, 0, 'C');
            $pdf->Cell(50, 2, $ecole->getEmail(), 0, 0, 'L');
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(30, 2, '', 0, 0, 'C');
            $pdf->Cell(40, 2, '', 0, 0, 'C');
            $pdf->Ln(3.5);
            $pdf->SetFont('helvetica', '', 8);
            $pdf->Cell(35, 2, '', 0, 0, 'C');
            $pdf->Cell(50, 2, $ecole->getTelephones(), 0, 0, 'L');
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(30, 2, ''.$classe->getLibele().'', 0, 0, 'C');
            $pdf->Cell(40, 2, ''.$periodeval->getDescription().'', 0, 0, 'C');
            
            
            $pdf->Ln(10);
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(100, 4, 'Nom:'.$eleve->getNomEleve().'', 0, 0, 'C');
            $pdf->Cell(40, 4, 'Prénom:'.$eleve->getPrenomEleve().'', 0, 0, 'C');
            $pdf->Ln(10);
             //$width_cell=array(40,40,40,70);
            $pdf->SetFont('helvetica','B',10);

            //Background color of header//
            $pdf->SetFillColor(193,229,252);
                
            $pdf->Cell(30,9.5,'Matières',1,0,'C',true);
            $pdf->Cell(40,5,'Moyennes',1,0,'C',true);
            $pdf->Cell(40,5,'Notes extrêmes',1,0,'C',true);
            $pdf->Cell(80,9.5,'Appréciations générales',1,0,'C',true);
            $pdf->Cell(0,5,'',0,1);
            
            $pdf->SetFont('helvetica','',10);
            $pdf->Cell(30,4,'',0,0);
            $pdf->Cell(20,4,'Elève',1,0,true);
            $pdf->Cell(20,4,'Classe',1,0,true);
            $pdf->Cell(20,4,'Min',1,0,true);
            $pdf->Cell(20,4,'Max',1,1,true);
            
            $z = 0;  $s=0;
       foreach ($allDiscipline as $discipline) {
            $totalCoefParDiscipline = $this->evaluationManager->CalculerTotalCoefParDiscipline($discipline, $classe, $periodeval); 
            $totalNoteParDiscipline = $this->evaluationManager->CalculerTotalNoteParDiscipline($eleve, $discipline, $classe, $periodeval);
            $NoteParDisciplineClasse = $this->evaluationManager->CalculerNoteParDisciplineClasse($discipline, $classe, $periodeval);
            $nb_eleve_evalue = $this->evaluationManager->CalculerQuantiteEleveEvalue($classe, $periodeval);
            $minimumNoteDisciplineClasse = $this->evaluationManager->CalculerMinimumNoteParDisciplineClasse($discipline, $classe, $periodeval);
            $maximumNoteDisciplineClasse = $this->evaluationManager->CalculerMaximumNoteParDisciplineClasse($discipline, $classe, $periodeval);
            $aprec ='';
            
            $pdf->SetFont('helvetica','BI',10);
            $pdf->Cell(30,5,$discipline->getAbrege(),1,0,'L');
            $pdf->Cell(20,5,round($totalNoteParDiscipline, 2).'/'.$totalCoefParDiscipline,1,0,'C');
            $pdf->Cell(20,5,round(($NoteParDisciplineClasse/$nb_eleve_evalue), 2).'/'.$totalCoefParDiscipline,1,0,'C');
            $pdf->SetFont('helvetica','BI',10);
            $pdf->Cell(20,5,round($minimumNoteDisciplineClasse, 2).'/'.$totalCoefParDiscipline,1,0,'C');
            $pdf->Cell(20,5,round($maximumNoteDisciplineClasse, 2).'/'.$totalCoefParDiscipline,1,0,'C');
            $pdf->SetFont('helvetica','',9);
            
            $pdf->Cell(80,5,$aprec,1,1,'C');
            $y = 0;  
               foreach ($this->entityManager->getRepository(Evaluation::class)->findAllNotesEleveByDiscipline($eleve, $discipline, $classe, $periodeval) as $eval){
                    
                   $totalNotesClasse = $this->evaluationManager->CalculerTotalNoteClasse($eval->getMatiereAffectee()->getMatiere(), $classe, $periodeval);
                   $minimumNotesClasse = $this->evaluationManager->CalculerMinimumNoteClasse($eval->getMatiereAffectee()->getMatiere(), $classe, $periodeval);
                   $maximumNotesClasse = $this->evaluationManager->CalculerMaximumNoteClasse($eval->getMatiereAffectee()->getMatiere(), $classe, $periodeval);
                   $minTotalNote[$y] = $minimumNotesClasse;
                   $NOTE_E = $eval->getNote();
                   $MAX_NOTE_CLA = round($maximumNotesClasse, 2);
                   $MIN_NOTE_CLA = round($minimumNotesClasse, 2);
                    $pdf->SetFont('helvetica','',10);
                    $pdf->Cell(30,5,'-'.$eval->getMatiereAffectee()->getMatiere()->getAbrege(),1,0,'L');
                    $pdf->Cell(20,5,$eval->getNote().'/'.$eval->getMatiereAffectee()->getCoefficient(),1,0,'C');
                    $pdf->Cell(20,5,round($totalNotesClasse, 2).'/'.$eval->getMatiereAffectee()->getCoefficient(),1,0,'C');
                    $pdf->Cell(20,5,round($minimumNotesClasse, 2),1,0,'C');
                    $pdf->Cell(20,5,round($maximumNotesClasse, 2),1,0,'C');
                    $pdf->SetFont('helvetica','',9);
                     if($NOTE_E == $MAX_NOTE_CLA & round(($MAX_NOTE_CLA*100)/$totalNotesClasse, 2)>80){
                        $aprec = 'Excellent, tu as la meilleure note de la classe !';  
                      }elseif($NOTE_E == $MIN_NOTE_CLA & $NOTE_E != 0){
                         $aprec = 'Très mal, tu as la note la plus petite de la classe';   
                      }elseif($NOTE_E == 0){
                         $aprec = 'L\'élève était absent, ou il l\'a raté';   
                      }elseif($NOTE_E < $MAX_NOTE_CLA & $NOTE_E < round((($MIN_NOTE_CLA + $MAX_NOTE_CLA)/2), 2)){
                         $aprec = 'Bien, mais il faut s\'investir davantage !';   
                      }elseif($NOTE_E < $MAX_NOTE_CLA & $NOTE_E > round((($MIN_NOTE_CLA + $MAX_NOTE_CLA)/2), 2)){
                         $aprec = 'Très bien, mais l\'élève peut faire mieux !';   
                      }elseif($NOTE_E < round((($MIN_NOTE_CLA + $MAX_NOTE_CLA)/2), 2) & $NOTE_E < ($totalNotesClasse/2) & $NOTE_E != 0){
                         $aprec = 'Très faible, beaucoup d\'efforts !';   
                      }
                    $pdf->Cell(80,5,$aprec,1,1,'C');
                    
                          $totalMoyenne[$s] = $totalNotesClasse;
                          $totalNote[$y]  = intval($eval->getNote());
                          $totalMinNoteClasse[$s] =$minimumNotesClasse; 
                          $totalMaxNoteClasse[$s] =$maximumNotesClasse;
                          $totalNoteDisc[$y] = intval($eval->getMatiereAffectee()->getCoefficient());
                           $y++; $s++;
               }
              
                         
            }
            $z++;
            $totalNotesMoyenne = array_sum($totalMoyenne);
            $moyenneNotesEleve = $this->evaluationManager->CalculerMoyenne($eleve, $classe, $periodeval);
            $totalCoefficient = $this->evaluationManager->CalculerTotalCoef($classe, $periodeval); 
            $totalNotesEleve = $this->evaluationManager->CalculerTotalNote($eleve, $classe, $periodeval);
           
            $totalMinNoteClasse2 = array_sum($totalMinNoteClasse);
            $totalMaxNoteClasse2 = array_sum($totalMaxNoteClasse);
            $pdf->SetFont('helvetica','B',10);
            $pdf->Cell(30,6,'Total',1,0,'C',true);
            $pdf->Cell(20,6,round($totalNotesEleve, 2).'/'.$totalCoefficient,1,0,'C',true);
            $pdf->Cell(20,6,round($totalNotesMoyenne, 2).'/'.$totalCoefficient,1,0,'C',true);
            $pdf->Cell(20,6,round($totalMinNoteClasse2, 2).'/'.$totalCoefficient,1,0,'C',true);
            $pdf->Cell(20,6,round($totalMaxNoteClasse2, 2).'/'.$totalCoefficient,1,0,'C',true);
            $pdf->Cell(80,6,'',1,0,'C',true);
            $pdf->Cell(0,5,'',0,1);
            $MOY_EL = round(($totalNotesEleve*10)/$totalCoefficient, 2);
            $aprecm = '';
            
            $pdf->SetFont('helvetica','B',10);
            $pdf->Cell(30,6,'Moyenne',1,0,'C',true);
            $pdf->Cell(20,6,round(($totalNotesEleve*10)/$totalCoefficient, 2).'/10',1,0,'C',true);
            $pdf->Cell(20,6,round(($totalNotesMoyenne*10)/$totalCoefficient, 2).'/10',1,0,'C',true);
            $pdf->Cell(20,6,round(($totalMinNoteClasse2*10)/$totalCoefficient, 2).'/10',1,0,'C',true);
            $pdf->Cell(20,6,round(($totalMaxNoteClasse2*10)/$totalCoefficient, 2).'/10',1,0,'C',true);
            $pdf->SetFont('helvetica','B',9);
                 if($MOY_EL > 4.99 & $MOY_EL < 6){
                        $aprecm = 'Réussite de justesse';  
                      }elseif($MOY_EL > 5.99 &  $MOY_EL < 7){
                         $aprecm = 'Acceptable, il faut s\'investir davantage';   
                      }elseif($MOY_EL > 6.99 &  $MOY_EL < 8){
                         $aprecm = 'Très bien, mais tu peux faire mieux';   
                      }elseif($MOY_EL > 7.99 &  $MOY_EL < 9){
                         $aprecm = 'Excellent resultat, continu ainsi';   
                      }elseif($MOY_EL > 8.99 &  $MOY_EL <= 10){
                         $aprecm = 'Parfait !, exceptionnelle';   
                      }   
                   
            $pdf->Cell(80,6,$aprecm,1,0,'C',true);
            $pdf->SetFont('helvetica','B',10);  
            $pdf->Cell(0,5,'',0,1);
            $pdf->Ln(20);
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(120, 4, '__________________', 0, 0, 'C');
            $pdf->Cell(30, 4, '______________', 0, 0, 'C');
            $pdf->Ln(4);
            $pdf->Cell(120, 4, 'Parent de l\'élève', 0, 0, 'C');
            $pdf->Cell(30, 4, 'La diréction', 0, 0, 'C');
            $pdf->SetFont('helvetica', '', 12);
           
            $pdf->endPage();
            $pdf->lastPage();
     }
            $pdf->Output('I');
            
        
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
       $id_periodeval = $_POST['periodeval'];
       $id_matiere = $_POST['matiere'];
       
       $nbeleve = count($json_string);
        if($nbeleve > 0){
        
        $periodeval = $this->entityManager->getRepository(Periodeval::class)
               ->findOneById($id_periodeval);
                
        $matiere = $this->entityManager->getRepository(MatiereAffectee::class)
               ->findOneById($id_matiere);
        
        for($i=0; $i<$nbeleve; $i++){
            $eleve= $this->entityManager->getRepository(ClasseEleves::class)
                 ->findOneById($json_string[$i]['id_eleve']);
                 //$this->evaluationManager->addNewPalmaresNotes($periodeval, $eleve, $matiere, $json_string[$i]['note']);
                $this->evaluationManager->addNewPalmaresNotes($periodeval, $eleve, $matiere, $json_string[$i]['note']);
         }
       }
       $jsonData = array(
               'libele' => 'Enregistrement reussi',
               'rang' => 'testok',
               'coefficient' => 'testok',
           );
       
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