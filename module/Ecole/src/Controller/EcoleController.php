<?php
namespace Ecole\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Ecole\Form\EcoleForm;
use Ecole\Entity\Ecole;


class EcoleController extends AbstractActionController
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
     * @var Ecole\Service\EcoleManager 
     */
    private $ecoleManager;
    
        
    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager, $ecoleManager) 
    {
        $this->entityManager = $entityManager;
        $this->ecoleManager = $ecoleManager; 
    }
  
    public function indexAction()
    {        
        $ecole = $this->entityManager->getRepository(Ecole::class)
                ->findAllEcoles();
        
        return new ViewModel([
            'ecole' =>  $ecole
        ]);
      
    }
    
    public function ajouterAction() 
    {     
    
        // Create the form.
        $form = new EcoleForm();
        
        // Check si la requette est postee.
        if ($this->getRequest()->isPost()) {
            
            // Get POST data.
            $data = $this->params()->fromPost();
            
            // Make certain to merge the files info!
            $request = $this->getRequest();
            $requestFile = $this->getRequest()->getFiles();
            $dataFile = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
            
            // Fill form with data.
            $form->setData($data);
            $form->setData($dataFile);
            
            if ($form->isValid()) {
                                
                // Get validated form data.
                $data = $form->getData();
                
                $dataFilePath = $this->ecoleManager->getImagePathByName($dataFile);
                $requestFilePath =str_replace('Array','',$dataFilePath.''.basename($requestFile['file']['name']));
                $requestFilePath =str_replace('./public','',$requestFilePath);
                
                // Use post manager service to add new post to database.                
                $this->ecoleManager->addNewEcole($data, $requestFilePath);
              
                // Go to the next step.
                return $this->redirect()->toRoute('ecole');
                // Redirect the user to "index" page
            }
        }
        // Render the view template.
        return new ViewModel([
            'form' => $form    
        ]);
      
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
        $form = new EcoleForm();
        
        // Get event ID.
        $id_ecole = (int)$this->params()->fromRoute('id', -1);
        
        // Validate input parameter
        if ($id_ecole<0) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Find the existing event in the database.
        $ecole = $this->entityManager->getRepository(Ecole::class)
                ->findOneById($id_ecole);        
        if ($ecole == null) {
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
                $this->eventManager->editEcole($ecole, $data);
                
                // Redirect the user to "admin" page.
                return $this->redirect()->toRoute('ecole', ['action'=>'index']);
            }
        } else {
            $data = [
                'nom' => $ecole->getNom(),
                'adresse' => $ecole->getAdresse(),
                'email' => $ecole->getEmail(),
                'telephones' => $ecole->getTelephones(),  
            ];
            
            $form->setData($data);
        }
        
        // Render the view template.
        return new ViewModel([
            'form' => $form,
            'ecole' => $ecole
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