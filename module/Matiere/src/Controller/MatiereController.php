<?php
namespace Matiere\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use Matiere\Form\MatiereForm;
use Matiere\Form\DisciplineForm;
use Matiere\Entity\Matiere;
use Matiere\Entity\Discipline;
use Zend\View\Model\JsonModel;

class MatiereController extends AbstractActionController
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
     * @var Matiere\Service\MatiereManager 
     */
    private $matiereManager;
    
    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager, $matiereManager) 
    {
        $this->entityManager = $entityManager;
        $this->matiereManager = $matiereManager; 
    }
  
    public function indexAction()
    {
	//$page = $this->params()->fromQuery('page', 1);
        
        $matieres = $this->entityManager->getRepository(Matiere::class)
                ->findAll();
        $disciplines = $this->entityManager->getRepository(Discipline::class)
                ->findAll();
        
        //$adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        //$paginator = new Paginator($adapter);
        //$paginator->setDefaultItemCountPerPage(10);        
        //$paginator->setCurrentPageNumber($page);
        
        return new ViewModel([
            'matieres' => $matieres,
            'disciplines'=>$disciplines
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
        $form = new MatiereForm();
        $formDiscipline = new DisciplineForm();
        
        //get data for discipline
        foreach($this->entityManager->getRepository(Discipline::class)->findAll() as $discipline) {
        $optionsDiscipline[$discipline->getId()] = $discipline->getLibeleDiscipline();
        }
        $form->get('discipline')->setValueOptions($optionsDiscipline);
        
        // select all discipline
        $allDiscipline = $this->entityManager->getRepository(Matiere::class)->findDisciplinesHavingAnyMatieres();
        // Check si la requette est postee.
        if ($this->getRequest()->isPost()) {
            
            // Get POST data.
            $data = $this->params()->fromPost();
            
            // Fill form with data.
            $form->setData($data);
            $formDiscipline->setData($data);
            if ($form->isValid()) {
                                
                // Get validated form data.
                $data = $form->getData();
                
                $discipline = $this->entityManager->getRepository(Discipline::class)->find($data['discipline']);
                $libele_matiere = $data['libele_matiere'];
                $abrege = $data['abrege'];
                $rang = $data['rang'];
                // Use post manager service to add new post to database.                
                $this->matiereManager->addNewMatiere($discipline, $libele_matiere, $abrege, $rang);
                // Go to the next step.
                return $this->redirect()->toRoute('matiere',['action'=>'add']);
                // Redirect the user to "index" page.
            // return $this->redirect()->toRoute('croyant', ['action'=>'index']);
            }elseif($formDiscipline->isValid()){
                $data = $formDiscipline->getData();
                
                // Use post manager service to add new post to database.                
                $this->matiereManager->addNewDiscipline($data);
                
                // Go to the next step.
                return $this->redirect()->toRoute('matiere', ['action'=>'add']);
            }
                
        }
        // Render the view template.
        return new ViewModel([
            'form' => $form,
            'formDiscipline'=>$formDiscipline,
            'allDiscipline' =>$allDiscipline
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
        $matiere = $this->entityManager->getRepository(Matiere::class)
                ->findOneById($id);
        
        if ($matiere == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
                
        return new ViewModel([
            'matiere' => $matiere
        ]);
    }
    
    public function viewdAction() 
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Find an entite with such ID.
        $disciplines = $this->entityManager->getRepository(Discipline::class)
                ->findOneById($id);
        
        if ($disciplines == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
                
        return new ViewModel([
            'discipline' => $disciplines
        ]);
    }
    
    
     public function editAction() 
    {
        // Create form.
        $form = new MatiereForm();
        
        // Get matiere ID.
        $matiereId = (int)$this->params()->fromRoute('id', -1);
        
        // Validate input parameter
        if ($matiereId<0) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        foreach($this->entityManager->getRepository(Discipline::class)->findAll() as $discipline) {
        $optionsDiscipline[$discipline->getId()] = $discipline->getLibeleDiscipline();
        }
        $form->get('discipline')->setValueOptions($optionsDiscipline);
        // Find the existing matiere in the database.
        $matiere = $this->entityManager->getRepository(Matiere::class)
                ->findOneById($matiereId);        
        if ($matiere == null) {
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
                $discipline = $this->entityManager->getRepository(Discipline::class)->find($data['discipline']);
                // Use post manager service update existing post.                
                $this->matiereManager->editMatiere($matiere, $data);
                
                // Redirect the user to "admin" page.
                return $this->redirect()->toRoute('matiere', ['action'=>'index']);
            }
        } else {
            $data = [
                'libele_matiere' => $matiere->getLibeleMatiere(),
                'abrege' => $matiere->getAbrege(),
                'discipline'=>$matiere->getDiscipline(),
                'rang' => $matiere->getRang(),  
            ];
            
            $form->setData($data);
        }
        
        // Render the view template.
        return new ViewModel([
            'form' => $form,
            'matiere' => $matiere
        ]);  
    }
    
     public function editdAction() 
    {
        // Create form.
        $form = new DisciplineForm();
        
        // Get matiere ID.
        $disciplineId = (int)$this->params()->fromRoute('id', -1);
        
        // Validate input parameter
        if ($disciplineId<0) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
       
        // Find the existing matiere in the database.
        $discipline = $this->entityManager->getRepository(Discipline::class)
                ->findOneById($disciplineId);        
        if ($discipline == null) {
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
                $this->matiereManager->editDiscipline($discipline, $data);
                
                // Redirect the user to "admin" page.
                return $this->redirect()->toRoute('matiere', ['action'=>'index']);
            }
        } else {
            $data = [
                'libele_discipline' => $discipline->getLibeleDiscipline()    
            ];
            
            $form->setData($data);
        }
        
        // Render the view template.
        return new ViewModel([
            'form' => $form,
            'discipline' => $discipline
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