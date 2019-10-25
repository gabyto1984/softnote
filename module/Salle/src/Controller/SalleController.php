<?php
namespace Salle\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use Salle\Form\SalleForm;
use Salle\Entity\Salle;
use Classe\Entity\Classe;

class SalleController extends AbstractActionController
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
     * @var Salle\Service\SalleManager 
     */
    private $salleManager;
    
    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager, $salleManager) 
    {
        $this->entityManager = $entityManager;
        $this->salleManager = $salleManager; 
    }
  
    public function indexAction()
    {        
        $salles = $this->entityManager->getRepository(Salle::class)
                ->findAllSalles();
        
        return new ViewModel([
            'salles' =>  $salles
        ]);
      
    }
    
    public function addAction() 
    {     
    
        // Create the form.
        $form = new SalleForm();
        
        foreach($this->entityManager->getRepository(Classe::class)->findAllClasses() as $classe) {
        $classes[$classe->getId()] = $classe->getLibele();
        }
        $form->get('classe')->setValueOptions($classes);
        
        // Check si la requette est postee.
        if ($this->getRequest()->isPost()) {
            
            // Get POST data.
            $data = $this->params()->fromPost();
            
            // Fill form with data.
            $form->setData($data);
            if ($form->isValid()) {
                                
                // Get validated form data.
                $data = $form->getData();
                
                $classe = $this->entityManager->getRepository(Classe::class)->findOneById($data['classe']);
                // Use post manager service to add new post to database.                
                $this->salleManager->addNewSalle($data, $classe);
              
                // Go to the next step.
                return $this->redirect()->toRoute('salle');
                // Redirect the user to "index" page.
            // return $this->redirect()->toRoute('croyant', ['action'=>'index']);
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
        $form = new SalleForm();
        
        // Get event ID.
        $salle_id = (int)$this->params()->fromRoute('id', -1);
        
        // Validate input parameter
        if ($salle_id<0) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Find the existing event in the database.
        $salle = $this->entityManager->getRepository(Salle::class)
                ->findOneById($salle_id);        
        if ($salle == null) {
            $this->getResponse()->setStatusCode(404);
            return;                        
        } 
        
        foreach($this->entityManager->getRepository(Classe::class)->findAll() as $classe) {
        $optionsClasse[$classe->getId()] = $classe->getLibele();
        }
        $form->get('classe')->setValueOptions($optionsClasse);
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
                $this->salleManager->editSalle($salle, $data);
                
                // Redirect the user to "admin" page.
                return $this->redirect()->toRoute('salle', ['action'=>'index']);
            }
        } else {
            $data = [
                'libele' => $salle->getLibele(),
                'numero' => $salle->getNumero(),
                'classe' => $salle->getClasse()->getId(),
                'quantite' => $salle->getQuantite()  
            ];
            
            $form->setData($data);
        }
        
        // Render the view template.
        return new ViewModel([
            'form' => $form,
            'salle' => $salle
        ]);  
    }
    
    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        $salle = $this->entityManager->getRepository(Salle::class)
                ->find($id);
        
        if ($salle == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $salle_verifie = $this->entityManager->getRepository(Salle::class)
                        ->findBySalle($salle->getClasse());
        if ($salle_verifie == null) {
        // Delete permission.
        //$this->salleManager->deleteSalle($salle);
        }else{
        // Add a flash message.
        $this->flashMessenger()->addSuccessMessage('Vous devez desaffecter d\'abord la matiere.'); 
        return $this->redirect()->toRoute('salle', ['action'=>'confirm']);
        }

        // Redirect to "confirm" page
        $this->flashMessenger()->addSuccessMessage('Suppresion avec succes');
        return $this->redirect()->toRoute('salle', ['action'=>'confirm']); 
    }
    
     public function confirmAction()
    {
      return new ViewModel();  
        
    }
    	
}