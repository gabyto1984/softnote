<?php
namespace Anneescolaire\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use Anneescolaire\Form\AnneescolaireForm;
use Anneescolaire\Entity\Anneescolaire;
use Zend\View\Model\JsonModel;

class AnneescolaireController extends AbstractActionController
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
     * @var Anneescolaire\Service\AnneescolaireManager 
     */
    private $anneescolaireManager;
    
    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager, $anneescolaireManager) 
    {
        $this->entityManager = $entityManager;
        $this->anneescolaireManager = $anneescolaireManager; 
    }
  
    public function indexAction()
    {
	        
        $anneescolaires = $this->entityManager->getRepository(AnneeScolaire::class)
                ->findAll();
             
        return new ViewModel([
            'anneescolaires' => $anneescolaires
        ]);
      
    }
    
   public function addLibeleDisciplineAction() 
    {     
       $json_string = $_POST['libele_discipline'];
       $formDiscipline = new DisciplineForm();
       $formDiscipline->get('libele_discipline')->setValue($json_string);
       if($formDiscipline->isValid()) {
           
                // Get validated form data.
                $data = $formDiscipline->getData();
                                
                // Use post manager service to add new post to database.                
                $this->matiereManager->addNewDiscipline($data);
              
                // Go to the next step.
                return $this->redirect()->toRoute('matiere');
           
       }else { 
           $view = new ViewModel(); 
        }   
    }
    
    public function addAction() 
    {     
    
        // Create the form.
        $form = new AnneescolaireForm();
        
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
                $this->anneescolaireManager->addNewAnneeScolaire($data);
              
                // Go to the next step.
                return $this->redirect()->toRoute('anneescolaire');
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
        $anneescolaire = $this->entityManager->getRepository(Anneescolaire::class)
                ->findOneById($id);
        
        if ($anneescolaire == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
                
        return new ViewModel([
            'anneescolaire' => $anneescolaire
        ]);
    }
    
    
    
     public function editAction() 
    {
        // Create form.
        $form = new AnneescolaireForm();
        
        // Get matiere ID.
        $anneescolaireId = (int)$this->params()->fromRoute('id', -1);
        
        // Validate input parameter
        if ($anneescolaireId<0) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $anneescolaire = $this->entityManager->getRepository(Anneescolaire::class)
                ->findOneById($anneescolaireId);
        
        if ($anneescolaire == null) {
            $this->getResponse()->setStatusCode(404);
            return;                        
        } 
        
        $statut = $anneescolaire->getStatut();
        
        // Check whether this event is a POST request.
        if ($this->getRequest()->isPost()) {
            
            // Get POST data.
            $data = $this->params()->fromPost();
            
            // Fill form with data.
            $form->setData($data);
            if ($form->isValid()) {
                                 
                // Get validated form data.
                $data = $form->getData();
                
                if($statut != $data['statut']){
                  if($data['statut'] == 1) {
                      $ancienne_annee_active = $this->entityManager->getRepository(Anneescolaire::class)->findOneByStatut(1); 
                      $this->anneescolaireManager->editStatutAnneeScolaire($ancienne_annee_active);
                  } 
                }
                
                // Use post manager service update existing post.                
                $this->anneescolaireManager->editAnneeScolaire($anneescolaire, $data);
                
                // Redirect the user to "admin" page.
                return $this->redirect()->toRoute('anneescolaire', ['action'=>'index']);
            }
        } else {
            $data = [
                'libele' => $anneescolaire->getLibele(),
                'statut'=>$anneescolaire->getStatut(),
                'categorie'=>$anneescolaire->getCategorie(),
                'commentaires' => $anneescolaire->getCommentaires()   
            ];
            
            $form->setData($data);
        }
        
        // Render the view template.
        return new ViewModel([
            'form' => $form,
            'anneescolaire' => $anneescolaire,           
        ]);  
    }
    
    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        $anneescolaire = $this->entityManager->getRepository(Anneescolaire::class)
                ->find($id);
        
        if ($anneescolaire == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        $verifie_annee = $this->entityManager->getRepository(Anneescolaire::class)
                        ->findByAnnee($anneescolaire);
        
        // Delete permission.
        if ($verifie_annee == null) {
        // Delete permission.
        $this->anneescolaireManager->deleteAnneeScolaire($anneescolaire);
        }else{
        // Add a flash message.
        $this->flashMessenger()->addSuccessMessage('Vous devez supprimer les evaluations et les periodes de cette annee scolaire');
        return $this->redirect()->toRoute('anneescolaire', ['action'=>'confirm']);
        }
        // Redirect to "index" page
        $this->flashMessenger()->addSuccessMessage('Suppression reussie !');
        return $this->redirect()->toRoute('anneescolaire', ['action'=>'confirm']);
                
    }
    
     public function confirmAction()
    {
      return new ViewModel();  
        
    }
    	
}