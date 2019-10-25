<?php
namespace Classe\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Classe\Form\ClasseForm;
use Classe\Entity\Classe;
use Salle\Entity\Salle;
use Eleve\Entity\Eleve;
use Anneescolaire\Entity\Anneescolaire;
use Matiere\Entity\Matiere;

class ClasseController extends AbstractActionController
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
     * @var Classe\Service\ClasseManager 
     */
    private $classeManager;
       
    
    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager, $classeManager) 
    {
        $this->entityManager = $entityManager;
        $this->classeManager = $classeManager; 
    }
  
    public function indexAction()
    {        
        $classes = $this->entityManager->getRepository(Classe::class)
                ->findAllClasses();
        
        return new ViewModel([
            'classes' =>  $classes
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
    
    public function afficherEleveMatiereClasseAction()
    {
        $id_classe = $_POST['classe'];
        //$id_periode = $_POST['periode'];
        $classe = $this->entityManager->getRepository(Classe::class)
               ->findOneById($id_classe);
                
        $request = $this->getRequest(); 
         if ($request->isXmlHttpRequest()) { 
           $jsonDataMatiere = array();
           $jsonDataEleve = array();
           $jsonData = array();
           $idx = 0; 
           $idx2 =0;
               
           foreach($classe->getMatiereAffectee()  as $matiere) { 
              $temp =[
                 'id' =>$matiere->getId(),
                 'libele' => $matiere->getMatiere()->getLibeleMatiere(), 
                 'rang' => $matiere->getMatiere()->getRangAsString(), 
                 'coefficient' => $matiere->getCoefficient(), 
              ];  
             $jsonDataMatiere[$idx++] = $temp; 
           }
           
           foreach($classe->getClasseEleves() as $eleve){
                $temp =[
                 'id'=>$eleve->getId(),
                 'nom' => $eleve->getEleve()->getNomEleve(), 
                 'prenom' => $eleve->getEleve()->getPrenomEleve(), 
              ];  
             $jsonDataEleve[$idx2++] = $temp;
           }
           $jsonData[0] = $jsonDataMatiere;
           $jsonData[1] = $jsonDataEleve;
           
            $view = new JsonModel($jsonData); 
           $view->setTerminal(true); 
         }else { 
             $view = new ViewModel(); 
        }  
       
      return $view;
         
    }
    
    public function afficherEleveMatiereClasseNonEvalueAction()
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
        /*
        $matiere = $this->entityManager->getRepository(MatiereAffectee::class)
               ->findOneById($id_matiere);
        
        $eleves = $this->entityManager->getRepository(Classe::class)
               ->findAllEleveNonEvalue($classe, $periodeval, $matiere);
        
          foreach($eleves as $eleve){
                $temp =[
                 'id'=>$eleve->getId(),
                 'nom' => $eleve->getNomEleve(), 
                 'prenom' => $eleve->getPrenomEleve(), 
              ];  
             $jsonDataEleve[$idx++] = $temp;
           }
           $jsonData[0] = $jsonDataEleve; 
           $jsonData[1] = $matiere->getCoefficient();
           
        
       $view = new JsonModel($jsonData); 
           $view->setTerminal(true);
           
      return $view;*/
         
         $jsonData = array(
               'messagederetour' => 'Une nouvelle classe a été affecté',
              
           );
        
       $view = new JsonModel($jsonData); 
           $view->setTerminal(true);
           
      return $view;
         
    }
    
    public function configurerAction(){
        
        $anneescolaire = $this->entityManager->getRepository(Anneescolaire::class)
                ->findOneByStatut(1);
                
        $salles = $this->entityManager->getRepository(Salle::class)
                ->findAllSalleNotConfig();
        
        $classes = $this->entityManager->getRepository(Classe::class)
                ->findAllClasses();
        
        $matieres = $this->entityManager->getRepository(Matiere::class)
                ->findAllMatieres();
        
        $eleves = $this->entityManager->getRepository(Eleve::class)
                ->findAllEleves2();
                
        return new ViewModel([
            'salles' => $salles,
            'classes' => $classes,
            'matieres' => $matieres,
            'anneescolaires'=>$anneescolaire,
            'eleves'=> $eleves
        ]);
    }
    
    public function affecterSalleAction(){
        
       $id_anneescolaire = $_POST['anneescolaire'];
       $json_string = $_POST['postData'];
      
       $anneescolaire= $this->entityManager->getRepository(Anneescolaire::class)
              ->findOneById($id_anneescolaire);
       
        $nb_salle = count($json_string);
        
        if($nb_salle > 0){
          for($i=0; $i<$nb_salle; $i++){  
           $salle = $this->entityManager->getRepository(Salle::class)
              ->findOneById($json_string[$i]['id_salle']);
           $this->classeManager->addNewConfiguration($json_string[$i]['libele_classe'], $salle, $anneescolaire);
          }
        }
        
        $jsonData = array(
               'messagederetour' => 'Une nouvelle classe a été affecté',
              
           );
        
       $view = new JsonModel($jsonData); 
           $view->setTerminal(true);
           
      return $view;
    }
    
    public function affecterMatieresAction(){
        $id_classe = $_POST['classe'];
        $json_string = $_POST['postData'];
        
        $classe= $this->entityManager->getRepository(Classe::class)
              ->findOneById($id_classe);
       
        $nb_matiere = count($json_string);
        
        if($nb_matiere > 0){
          for($i=0; $i<$nb_matiere; $i++){  
           $matiere = $this->entityManager->getRepository(Matiere::class)
              ->findOneById($json_string[$i]['id_matiere']);
           $this->classeManager->addNewMatieresAffectees($matiere, $classe, $json_string[$i]['coef']);
          }
        }
        
        $jsonData = array(
               'messagederetour' => 'Une nouvelle classe a été affecté',
              
           );
        
       $view = new JsonModel($jsonData); 
           $view->setTerminal(true);
           
      return $view;
        
    }
    
    
    public function affecterElevesAction()
    {
       $id_classe = $_POST['id_classe'];
        $json_string = $_POST['postData'];
        
        $classe= $this->entityManager->getRepository(Classe::class)
              ->findOneById($id_classe);
       
        $nb_eleve = count($json_string);
        
        if($nb_eleve > 0){
          for($i=0; $i<$nb_eleve; $i++){  
           $eleve = $this->entityManager->getRepository(Eleve::class)
              ->findOneById($json_string[$i]['id_eleve']);
           $this->classeManager->addNewEleveClasse($eleve, $classe);
          }
        }
        
        $jsonData = array(
               'messagederetour' => 'Une nouvelle classe a été affecté',
              
           );
        
       $view = new JsonModel($jsonData); 
           $view->setTerminal(true);
           
      return $view;
    }
    
      
     public function editAction() 
    {
        // Create form.
        $form = new ClasseForm();
        
        // Get classe ID.
        $id_classe = (int)$this->params()->fromRoute('id', -1);
        
        // Validate input parameter
        if ($id_classe<0) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Find the existing classe in the database.
        $classe = $this->entityManager->getRepository(Classe::class)
                ->findOneById($id_classe);        
        if ($classe == null) {
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
                $this->classeManager->editClasse($classe, $data);
                
                // Redirect the user to "admin" page.
                return $this->redirect()->toRoute('classe', ['action'=>'index']);
            }
        } else {
            $data = [
                'libele' => $classe->getLibele(),
                'niveau' => $classe->getNiveau(),
            ];
            
            $form->setData($data);
        }
        
        // Render the view template.
        return new ViewModel([
            'form' => $form,
            'classe' => $classe
        ]);  
    }
    
    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        $classe = $this->entityManager->getRepository(Classe::class)
                ->find($id);
        
        if ($classe == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        $classe_verifie = $this->entityManager->getRepository(Classe::class)
                        ->findByClasse($classe);
        
        if ($classe_verifie == null) {
            // Delete permission.
        $this->classeManager->deleteClasse($classe);
        }else{
            $this->flashMessenger()->addSuccessMessage('Vous devez desaffecter cette classe.');
            return $this->redirect()->toRoute('classe', ['action'=>'confirm']);
        } 
                
        // Add a flash message.
        $this->flashMessenger()->addSuccessMessage('Suppression avec succes.');

        // Redirect to "confirm" page
        return $this->redirect()->toRoute('classe', ['action'=>'confirm']); 
    }
    
     public function confirmAction()
    {
      return new ViewModel();  
        
    }
    	
}