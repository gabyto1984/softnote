<?php
namespace Periodeval\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use Periodeval\Form\PeriodevalForm;
use Periodeval\Entity\Periodeval;
use Anneescolaire\Entity\Anneescolaire;
use Zend\View\Model\JsonModel;

class PeriodevalController extends AbstractActionController
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
     * @var Periodeval\Service\PeriodevalManager 
     */
    private $periodevalManager;
    
    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager, $anneescolaireManager) 
    {
        $this->entityManager = $entityManager;
        $this->periodevalManager = $anneescolaireManager; 
    }
  
    public function indexAction()
    {
	        
        $periodeval = $this->entityManager->getRepository(Periodeval::class)
                ->findAll(); 
               
        return new ViewModel([
            'periodevals' => $periodeval
        ]);
      
    }
       
    public function addAction() 
    {     
    
        // Create the form.
        $form = new PeriodevalForm();
        
        //get data for discipline
        foreach($this->entityManager->getRepository(Anneescolaire::class)->findAll() as $anneescolaire) {
        $optionsAnnee[$anneescolaire->getId()] = $anneescolaire->getLibele();
        }
        $form->get('anneescolaire')->setValueOptions($optionsAnnee);
        
        // Check si la requette est postee.
        if ($this->getRequest()->isPost()) {
            
            // Get POST data.
            $data = $this->params()->fromPost();
           
            // Fill form with data.
            $form->setData($data);
            if ($form->isValid()) {
                                
                // Get validated form data.
                $data = $form->getData();
                                 
                $anneescolaire = $this->entityManager->getRepository(Anneescolaire::class)->findOneById($data['anneescolaire']);
            
                // Use post manager service to add new post to database.                
                $this->periodevalManager->addNewPeriodeval($anneescolaire, $data);
              
                // Go to the next step.
                return $this->redirect()->toRoute('periodeval');
                // Redirect the user to "index" page.
            // return $this->redirect()->toRoute('anneescolaire', ['action'=>'index']);
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
        $periodeval = $this->entityManager->getRepository(Periodeval::class)
                ->findOneById($id);
        
        if ($periodeval == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
                
        return new ViewModel([
            'periodeval' => $periodeval
        ]);
    }
    
    
     public function editAction() 
    {
        // Create form.
        //$form = new PeriodevalForm();
        
        // Get matiere ID.
        $periodevalId = (int)$this->params()->fromRoute('id', -1);
        
        // Validate input parameter
        if ($periodevalId<0) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        foreach($this->entityManager->getRepository(Anneescolaire::class)->findAll() as $anneescolaire) {
        $optionsAnnee[$anneescolaire->getId()] = $anneescolaire->getLibele();
        }
        
        
        // Find the existing matiere in the database.
        $periodeval = $this->entityManager->getRepository(Periodeval::class)
                ->findOneById($periodevalId);        
        if ($periodeval == null) {
            $this->getResponse()->setStatusCode(404);
            return;                        
        } 
        
        // Create user form
        $form = new PeriodevalForm('update', $this->entityManager, $periodeval);
        
        $form->get('anneescolaire')->setValueOptions($optionsAnnee);
        // Check whether this event is a POST request.
        if ($this->getRequest()->isPost()) {
            
            // Get POST data.
            $data = $this->params()->fromPost();
            
            // Fill form with data.
            $form->setData($data);
            if ($form->isValid()) {
                                 
                // Get validated form data.
                $data = $form->getData();
                $anneescolaire = $this->entityManager->getRepository(Anneescolaire::class)->find($data['anneescolaire']);
                // Use post manager service update existing post.                
                $this->periodevalManager->editPeriodeval($periodeval, $anneescolaire, $data);
                
                // Redirect the user to "admin" page.
                return $this->redirect()->toRoute('periodeval', ['action'=>'index']);
            }
        } else {
            $data = [
                'description' => $periodeval->getDescription(),
                'anneescolaire'=>$periodeval->getAnneeScolaire()->getId(),
                'date_debut' => $periodeval->getDateDebut(),
                'date_fin' => $periodeval->getDateFin(),
                'commentaires' => $periodeval->getCommentaires(),
            ];
            
            $form->setData($data);
        }
        
        // Render the view template.
        return new ViewModel([
            'form' => $form,
            'periodeval' => $periodeval
        ]);  
    }
    
    
    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        $periodeval = $this->entityManager->getRepository(Periodeval::class)
                ->find($id);
        
        if ($periodeval == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Delete permission.
        $this->periodevalManager->deletePeriodeval($periodeval);
        
        // Add a flash message.
        //$this->flashMessenger()->addSuccessMessage('Cette période a été supprimée avec succes.');

        // Redirect to "confirm" page
        return $this->redirect()->toRoute('periodeval', ['action'=>'index']); 
    }
    
     public function confirmAction()
    {
      return new ViewModel();  
        
    }
    	
}