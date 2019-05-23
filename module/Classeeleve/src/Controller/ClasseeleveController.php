<?php
namespace Classeeleve\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Classeeleve\Form\ClasseeleveForm;
use Classeeleve\Entity\Classeeleve;
use Anneescolaire\Entity\Anneescolaire;
use Classe\Entity\Classe;
use Eleve\Entity\Eleve;

class ClasseeleveController extends AbstractActionController
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
     * Configuration manager.
     * @var Classeeleve\Service\ClasseeleveManager 
     */
    private $classeeleveManager;
    
    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager, $classeeleveManager) 
    {
        $this->entityManager = $entityManager;
        $this->classeeleveManager = $classeeleveManager; 
    }
  
    public function indexAction()
    {
	$page = $this->params()->fromQuery('page', 1);
        
        $query = $this->entityManager->getRepository(Eleve::class)
                ->findAllEleves();
        
        $classes = $this->entityManager->getRepository(Classe::class)
                ->findAllClasses();
        
         $anneescolaire = $this->entityManager->getRepository(Anneescolaire::class)
                ->findOneByStatut(2);
        
        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);        
        $paginator->setCurrentPageNumber($page);
        
        return new ViewModel([
            'eleves' => $paginator,
            'classes' => $classes,
            'anneescolaire' => $anneescolaire
        ]);
      
    }
    
    // Affectation d'un seul eleve lien affecter
    public function affecterEleveAction() 
    {     
       $id_eleve = $_POST['eleve'];
       $id_classe = $_POST['classe'];
       $id_anneescolaire = $_POST['anneescolaire'];
       $classe = $this->entityManager->getRepository(Classe::class)
              ->findOneById($id_classe);
       
       $eleve= $this->entityManager->getRepository(Eleve::class)
              ->findOneById($id_eleve);
       
       $anneescolaire= $this->entityManager->getRepository(Anneescolaire::class)
              ->findOneById($id_anneescolaire);
         
       $this->classeeleveManager->addNewAffectation($anneescolaire, $classe, $eleve);
       
        $jsonData = array(
               'messagederetour' => 'Cet élève a été affecté',
              
           );
        
       $view = new JsonModel($jsonData); 
           $view->setTerminal(true);
           
      return $view;
        
    } 
    
    
    // Affectation d'un tableau d'eleves Bouton Enregistrer
    
     public function affecterElevesAction() 
    {     
       $id_eleve = $_POST['eleves'];
       $id_classe = $_POST['classe'];
       $nbeleve = count($id_eleve);
       //$matiere = array();
        if($nbeleve > 0){
        $classe = $this->entityManager->getRepository(Classe::class)
              ->findOneById($id_classe);
        
        for($i=0; $i<$nbeleve; $i++){
         $eleve= $this->entityManager->getRepository(Eleve::class)
                 ->findOneById($id_eleve[$i]['id_eleve']);
         
         $this->classeeleveManager->addNewAffectation($classe,$eleve);
         }
       }
       
        $jsonData = array(
               'messagederetour' => 'Ces élèves ont été affectés',
              
           );
       
       $view = new JsonModel($jsonData); 
           $view->setTerminal(true);
           
      return $view;
        
    } 
    
    public function afficherElevesAction()
    {
       $id_classe = $_POST['classe'];
       if ($id_classe<1) {
            $this->getResponse()->setStatusCode(404);
           return;
        }
        
        $classe = $this->entityManager->getRepository(Classe::class)
                ->findOneById($id_classe);
        
        $eleves = $this->entityManager->getRepository(Eleve::class)
                ->findAllElevesClasse($classe);
       $jsonDataEleves = array();
       $request = $this->getRequest(); 
         if ($request->isXmlHttpRequest()) { 
           
           $idx = 0;
           foreach($eleves  as $eleve) { 
              $temp =[
                 'id_eleve' =>$eleve->getId(),
                 'nom' => $eleve->getNomEleve(), 
                 'prenom' => $eleve->getPrenomEleve(), 
              ];  
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
    
     public function confirmAction()
    {
      return new ViewModel();  
        
    }
    	
}