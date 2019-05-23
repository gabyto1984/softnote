<?php
namespace Enseignee\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Enseignee\Form\EnseigneeForm;
use Enseignee\Entity\Enseignee;
use Classe\Entity\Classe;
use Matiere\Entity\Matiere;
use Periodeval\Entity\Periodeval;

class EnseigneeController extends AbstractActionController
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
     * Croyant manager.
     * @var Enseignee\Service\EnseigneeManager 
     */
    private $enseigneeManager;
    
    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager, $enseigneeManager) 
    {
        $this->entityManager = $entityManager;
        $this->enseigneeManager = $enseigneeManager; 
    }
  
    public function indexAction()
    {
        $matieres = $this->entityManager->getRepository(Matiere::class)
                ->findAllMatieres();
        $classes = $this->entityManager->getRepository(Classe::class)
                ->findAllClasses();
        $periodeval = $this->entityManager->getRepository(Periodeval::class)
                ->findAllPeriodeval();
        
        return new ViewModel([
            'matieres' => $matieres,
            'classes' => $classes,
            'periodeval' => $periodeval
        ]);
      
    }
    
    public function addAction() 
    {   
       $json_string = $_POST['postData'];
       $id_classe = $_POST['classe'];
       $id_periode = $_POST['periode'];
       $nbmatiere = count($json_string);
        if($nbmatiere > 0){
            
        $periodeval = $this->entityManager->getRepository(Periodeval::class)
               ->findOneById($id_periode);
        
        $classe = $this->entityManager->getRepository(Classe::class)
               ->findOneById($id_classe);
        
        for($i=0; $i<$nbmatiere; $i++){
            $matiere= $this->entityManager->getRepository(Matiere::class)
                 ->findOneById($json_string[$i]['id_matiere']);
                $this->enseigneeManager->addNewAffectation($periodeval, $classe,$matiere,$json_string[$i]['coef']);
         }
       }
       
       $jsonData = array(); 
       $jsonData[1]=['id' => 'Success',  
                 'categorie' =>"'".$json_string[0]['id_matiere']."'",
           ]; 
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
    
    public function affichermatiereclasseeAction(){
        $json_string = $_POST['classe'];
        $id_periode = $_POST['periode'];
        $classe = $this->entityManager->getRepository(Classe::class)
               ->findOneById($json_string);
        
         $periode = $this->entityManager->getRepository(Periodeval::class)
                   ->findOneById($id_periode);
        
        $matieres = $this->entityManager->getRepository(Matiere::class)
                   ->findMatiereNotInClasse($classe, $periode);
        
        $data = $this->entityManager->getRepository(Enseignee::class)
                ->findAllMatiereClasse($classe, $periode);
        
        $request = $this->getRequest(); 
         if ($request->isXmlHttpRequest()) { 
           $jsonDataEnseignee = array();
           $jsonDataMatiere = array();
           $jsonData = array();
           $idx = 0; 
           $idx2 =0;
           foreach($data  as $enseignee) { 
              $temp =[
                 'id_enseignee' =>$enseignee->getId(),
                 'libele' => $enseignee->getMatiere()->getLibeleMatiere(), 
                 'rang' => $enseignee->getMatiere()->getRangAsString(), 
                 'coefficient' => $enseignee->getCoefficient(),
              ];  
             $jsonDataEnseignee[$idx++] = $temp; 
           }
          foreach($matieres as $matiere){
                $temp =[
                 'id'=>$matiere->getId(),
                 'libele' => $matiere->getLibeleMatiere(), 
                 'rang' => $matiere->getRangAsString(), 
              ];  
             $jsonDataMatiere[$idx2++] = $temp;
           }
           $jsonData[0] = $jsonDataMatiere;
           $jsonData[1] = $jsonDataEnseignee;
           
           
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