<?php
namespace Test\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use Test\Form\TestForm;
use Test\Entity\Emprunter;
use Test\Entity\Personne;
use Test\Entity\Livre;

class TestController extends AbstractActionController
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
     * @var Test\Service\LivreManager 
     */
    private $livreManager;
    
    /**
     * Croyant manager.
     * @var Test\Service\PersonneManager 
     */
    private $personneManager;
    
    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager, $livreManager, $personneManager) 
    {
        $this->entityManager = $entityManager;
        $this->livreManager = $livreManager; 
        $this->personneManager = $personneManager; 
    }
  
    public function indexAction()
    {        
        $emprunts = $this->entityManager->getRepository(Emprunter::class)
                ->findAllEmprunts();
        
        return new ViewModel([
            'emprunts' =>  $emprunts
        ]);
      
    }
    
    public function addAction() 
    {     
    
        // Create the form.
        $form = new ClasseForm();
        
        // Check si la requette est postee.
        if ($this->getRequest()->isPost()) {
            
            // Get POST data.
            $data = $this->params()->fromPost();
            
            // Fill form with data.
            $form->setData($data);
            if ($form->isValid()) {
                                
                // Get validated form data.
                $data = $form->getData();
                
                
                // Use post manager service to add new post to database.                
                $this->classeManager->addNewClasse($data);
              
                // Go to the next step.
                return $this->redirect()->toRoute('classe');
                // Redirect the user to "index" page.
            // return $this->redirect()->toRoute('croyant', ['action'=>'index']);
            }
        }
        // Render the view template.
        return new ViewModel([
            'form' => $form    
        ]);
      
    } 
    
   public function viewempruntAction() 
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Find an entite with such ID.
        $emprunt = $this->entityManager->getRepository(Emprunter::class)
                ->findOneById($id);
        
        if ($emprunt == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
                
        return new ViewModel([
            'emprunt' => $emprunt
        ]);
    }
    
    public function viewpersonneAction() 
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Find an entite with such ID.
        $personne = $this->entityManager->getRepository(Personne::class)
                ->findOneById($id);
        
        if ($personne == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
                
        return new ViewModel([
            'personne' => $personne
        ]);
    }
    
    public function viewlivreAction() 
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Find an entite with such ID.
        $livre = $this->entityManager->getRepository(Livre::class)
                ->findOneById($id);
        
        if ($livre == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
                
        return new ViewModel([
            'livre' => $livre
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
    
    	
}