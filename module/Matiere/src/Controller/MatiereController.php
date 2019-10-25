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
use Classe\Entity\Classe;
use Matiere\Entity\MatiereAffectee;
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
    public function afficherMatiereNotInClasseAction(){
        $id_classe = $_POST['id_classe'];
        
        $matieres = $this->entityManager->getRepository(Matiere::class)
                   ->findAllMatieresNotInClasse($id_classe);
        
        $request = $this->getRequest(); 
         if ($request->isXmlHttpRequest()) {
            $jsonData_matieres = array();
            $jsonData_retour = array();
             $idx = 0;
             
            foreach($matieres  as $matiere) {
                $tab_matiere =[
                 'id_matiere' =>$matiere->getId(),
                 'libele_matiere' => $matiere->getLibeleMatiere(), 
                 'rang' => $matiere->getRangAsString(), 
              ];
            $jsonData_matieres[$idx++] = $tab_matiere;
            }
            
             $jsonData_retour[0] = $jsonData_matieres;
            
           $view = new JsonModel($jsonData_retour); 
          $view->setTerminal(true);
         }else { 
             $view = new ViewModel(); 
        }  
       
      return $view;
    }
    
     public function afficherMatiereClasseAction(){
        $json_string = $_POST['classe'];
        //$id_periode = $_POST['periode'];
        $classe = $this->entityManager->getRepository(Classe::class)
               ->findOneById($json_string);
                
        $matieres_not_in = $this->entityManager->getRepository(Matiere::class)
                       ->findAllMatieresNotInClasse($classe);
        
        $matieres_in = $this->entityManager->getRepository(Matiere::class)
                     ->findAllMatiereInClasse($classe);
        
        $request = $this->getRequest(); 
         if ($request->isXmlHttpRequest()) { 
           $jsonDataEnseignee = array();
           $jsonDataMatiere = array();
           $jsonData = array();
           $idx = 0; 
           $idx2 =0;
           foreach($matieres_in  as $enseignee) { 
              $temp =[
                 'id' =>$enseignee->getId(),
                 'libele' => $enseignee->getMatiere()->getLibeleMatiere(), 
                 'rang' => $enseignee->getMatiere()->getRangAsString(), 
                 'coefficient' => $enseignee->getCoefficient(), 
              ];  
             $jsonDataEnseignee[$idx++] = $temp; 
           }
          foreach($matieres_not_in as $matiere){
                $temp =[
                 'id'=>$matiere->getId(),
                 'libele' => $matiere->getLibeleMatiere(), 
                 'rang' => $matiere->getRangAsString(), 
              ];  
             $jsonDataMatiere[$idx2++] = $temp;
           }
           $jsonData[0] = $jsonDataMatiere;
           $jsonData[1] = $jsonDataEnseignee;
          
           $view = new JsonModel($jsonData); 
           $view->setTerminal(true); 
          } else { 
             $view = new ViewModel(); 
        }  
       
      return $view;
        
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
    
    public function affecterAction(){
        
        $matieres = $this->entityManager->getRepository(Matiere::class)
                ->findAllMatieres();
        $classes = $this->entityManager->getRepository(Classe::class)
                ->findAllClasses();
                
        return new ViewModel([
            'matieres' => $matieres,
            'classes' => $classes
        ]);
    }
    
    public function desaffecterAction(){
       $json_string = $_POST['matiere'];
       $matiereaffectee = $this->entityManager->getRepository(MatiereAffectee::class)
               ->findOneById($json_string);
       
       if ($matiereaffectee == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        $this->matiereManager->deleteMatiereAffectee($matiereaffectee);
        
       $jsonData = array(
               'libele' => 'Test ok'
           );
            $view = new JsonModel($jsonData); 
          $view->setTerminal(true); 
        return $view;  
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
        
        $matiere = $this->entityManager->getRepository(Matiere::class)
                ->find($id);
        
        if ($matiere == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        $matiere_verifie = $this->entityManager->getRepository(Matiere::class)
                        ->findByMatiere($matiere);
        if ($matiere_verifie == null) {
        // Delete permission.
        $this->matiereManager->deleteMatiere($matiere);
        }else{
           
        // Add a flash message.
        $this->flashMessenger()->addSuccessMessage('Vous devez desaffecter d\'abord la matiere.'); 
        return $this->redirect()->toRoute('matiere', ['action'=>'confirm']);
        }
        
        // Redirect to "confirm" page
        return $this->redirect()->toRoute('matiere', ['action'=>'confirm']); 
    }
    
    public function deletedAction()
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        $discipline = $this->entityManager->getRepository(Discipline::class)
                      ->find($id);
        
        if ($discipline == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        $discipline_verifie = $this->entityManager->getRepository(Matiere::class)
                        ->findByDiscipline($discipline);
        if ($discipline_verifie == null) {
        // Delete permission.
        $this->matiereManager->deleteDiscipline($discipline);
        }else{
           
        // Add a flash message.
        $this->flashMessenger()->addSuccessMessage('Vous devez desaffecter d\'abord les matieres que contient cette discipline.'); 
        return $this->redirect()->toRoute('matiere', ['action'=>'confirm']);
        }
        
        // Redirect to "confirm" page
        return $this->redirect()->toRoute('matiere', ['action'=>'confirm']); 
    }
    
     public function confirmAction()
    {
      return new ViewModel();  
        
    }
    	
}