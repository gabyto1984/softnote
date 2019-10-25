<?php
namespace Eleve\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\View\Model\JsonModel;
use Zend\Paginator\Paginator;
use Eleve\Form\EleveForm;
use Eleve\Entity\Eleve;
use Eleve\Form\ContactForm;



class EleveController extends AbstractActionController
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
     * Eleve manager.
     * @var Eleve\Service\EleveManager 
     */
    private $eleveManager;
    
    /**
     * Image manager.
     * @var Eleve\Service\ImageManager;
     */
    private $imageManager;
    
    
    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager, $eleveManager, $imageManager) 
    {
        $this->entityManager = $entityManager;
        $this->eleveManager = $eleveManager; 
        $this->imageManager = $imageManager; 
    }
    
     public function indexAction()
    {
	$page = $this->params()->fromQuery('page', 1);
        
        // Get the list of already saved files.
        $files = $this->imageManager->getSavedFiles();
        
        $query = $this->entityManager->getRepository(Eleve::class)
                ->findAllEleves();
        
        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);        
        $paginator->setCurrentPageNumber($page);
        
        return new ViewModel([
            'eleves' => $paginator,
            'files'=>$files
        ]);
      
    }
    
    public function afficherElevesAdmisAction()
    {
        $id_classe = $_POST['id_classe'];
        //$eleves = array();
        $eleves = $this->entityManager->getRepository(Eleve::class)
                   ->findAllElevesAdmis($id_classe);
        
        $request = $this->getRequest(); 
         if ($request->isXmlHttpRequest()) {
            $jsonData_eleves = array();
            $jsonData_retour = array();
             $idx = 0;
             
            foreach($eleves  as $eleve) {
                $tab_eleve =[
                 'id_eleve' =>$eleve->getId(),
                 'nom_eleve' => $eleve->getNomEleve(), 
                 'prenom_eleve' => $eleve->getPrenomEleve(),
              ];
            $jsonData_eleves[$idx++] = $tab_eleve;
            }
            
             $jsonData_retour[0] = $jsonData_eleves;
                       
           $view = new JsonModel($jsonData_retour); 
          $view->setTerminal(true);
         }else { 
             $view = new ViewModel(); 
        }  
       
      return $view;
    }
    
    public function afficherElevesParClasseAction()
    {
        $id_classe = $_POST['id_classe'];
        //$eleves = array();
        $eleves = $this->entityManager->getRepository(Eleve::class)
                   ->findAllElevesClasse($id_classe);
        
        $request = $this->getRequest(); 
         if ($request->isXmlHttpRequest()) {
            $jsonData_eleves = array();
            $jsonData_retour = array();
             $idx = 0;
             
            foreach($eleves  as $eleve) {
                $tab_eleve =[
                 'id_eleve' =>$eleve->getId(),
                 'nom_eleve' => $eleve->getNomEleve(), 
                 'prenom_eleve' => $eleve->getPrenomEleve(),
                 'statut_eleve' => $eleve->getStatusAsString(),
              ];
            $jsonData_eleves[$idx++] = $tab_eleve;
            }
            
             $jsonData_retour[0] = $jsonData_eleves;
                       
           $view = new JsonModel($jsonData_retour); 
          $view->setTerminal(true);
         }else { 
             $view = new ViewModel(); 
        }  
       
      return $view;
        
    }
    
     public function addAction() 
    {     
    
        // Create the form.
        $form = new EleveForm();
        
        $currentDate = date('Y-m-d H:i:s');
        $long = strtotime($currentDate);
        $v_date = $long - 14400;
        $TodayDate = date('Y-m-d', $v_date);
        
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
                $dataFilePath = $this->imageManager->getImagePathByName($dataFile);
                $requestFilePath =str_replace('Array','',$dataFilePath.''.basename($requestFile['file']['name']));
                $requestFilePath =str_replace('./public','',$requestFilePath);
                // Use post manager service to add new post to database.                
                $this->eleveManager->addNewEleve($data, $requestFilePath);
              
                // Go to the next step.
                return $this->redirect()->toRoute('eleve');
                // Redirect the user to "index" page.
            // return $this->redirect()->toRoute('croyant', ['action'=>'index']);
            }
        }else {
            $data = [
                'lieu_naissance' => ''
            ];
            
            $form->setData($data);
        }
        // Render the view template.
        return new ViewModel([
            'form' => $form    
        ]);
    } 
    
     /**
     * This is the 'file' action that is invoked when a user wants to 
     * open the image file in a web browser or generate a thumbnail.        
     */
    public function fileAction() 
    {
        // Get the file name from GET variable
        $fileName = $this->params()->fromQuery('name', '');
                
        // Check whether the user needs a thumbnail or a full-size image
        $isThumbnail = (bool)$this->params()->fromQuery('thumbnail', false);
        
        // Validate input parameters
        if (empty($fileName) || strlen($fileName)>128) {
            throw new \Exception('File name is empty or too long');
        }
        
        // Get path to image file
        $fileName = $this->imageManager->getImagePathByName($fileName);
                       
        // Resize the image
        $fileName = $this->imageManager->resizeImage($fileName);
        
        // Get image file info (size and MIME type).
        $fileInfo = $this->imageManager->getImageFileInfo($fileName);        
        if ($fileInfo===false) {
            // Set 404 Not Found status code
            $this->getResponse()->setStatusCode(404);            
            return;
        }
                
        // Write HTTP headers.
        $response = $this->getResponse();
        $headers = $response->getHeaders();
        $headers->addHeaderLine("Content-type: " . $fileInfo['type']);        
        $headers->addHeaderLine("Content-length: " . $fileInfo['size']);
            
        // Write file content        
        $fileContent = $this->imageManager->getImageFileContent($fileName);
        if($fileContent!==false) {                
            $response->setContent($fileContent);
        } else {        
            // Set 500 Server Error status code
            $this->getResponse()->setStatusCode(500);
            return;
        }
        
        if($isThumbnail) {
            // Remove temporary thumbnail image file.
            unlink($fileName);
        }
        
        // Return Response to avoid default view rendering.
        return $this->getResponse();
    }    
    
    
     public function editAction() 
    {
        // Create form.
        $form = new EleveForm();
        
        // Get croyant ID.
        $eleveId = (int)$this->params()->fromRoute('id', -1);
        
        // Validate input parameter
        if ($eleveId<0) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Find the existing eleve in the database.
        $eleve = $this->entityManager->getRepository(Eleve::class)
                ->findOneById($eleveId);        
        if ($eleve == null) {
            $this->getResponse()->setStatusCode(404);
            return;                        
        } 
        
        // Check whether this croyant is a POST request.
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
                
                $dataFilePath = $this->imageManager->getImagePathByName($dataFile);
                $requestFilePath =str_replace('Array','',$dataFilePath.''.basename($requestFile['file']['name']));
                $requestFilePath =str_replace('./public','',$requestFilePath);
                
                // Use post manager service update existing eleve.                
                $this->eleveManager->updateEleve($eleve, $data, $requestFilePath);
                
                // Redirect the user to "admin" page.
                return $this->redirect()->toRoute('eleve', ['action'=>'index']);
            }
        } else {
            $data = [
                'nom_eleve' => $eleve->getNomEleve(),
                'prenom_eleve' => $eleve->getPrenomEleve(),
                'date_naissance' => $eleve->getDateNaissance(),
                'lieu_naissance' => $eleve->getLieuNaissance(),
                'sexe' => $eleve->getSexe(),  
                'code_eleve' => $eleve->getCodeEleve(),
                'statut' => $eleve->getStatus(),
                'email' => $eleve->getEmail(),
                'file' => $eleve->getPhotoEleve(),
            ];
            
            $form->setData($data);
        }
        
        // Render the view template.
        return new ViewModel([
            'form' => $form,
            'eleve' => $eleve
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
        $eleve = $this->entityManager->getRepository(Eleve::class)
                ->findOneById($id);
        
        if ($eleve == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
                
        return new ViewModel([
            'eleve' => $eleve
        ]);
    }
    
   
    
    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        $eleve = $this->entityManager->getRepository(Eleve::class)
                ->find($id);
        
        if ($eleve == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
               
        $verifie_eleve_classe = $this->entityManager->getRepository(Eleve::class)
                        ->findByEleve($eleve);
        
        // Delete permission.
        if ($verifie_eleve_classe == null) {
        $this->eleveManager->deleteEleve($eleve);
        }else{
        // Add a flash message.
        $this->flashMessenger()->addSuccessMessage('Vous devez deaffecter cet eleve d\'abbord.');
        return $this->redirect()->toRoute('eleve', ['action'=>'confirm']);
        }
        // Redirect to "index" page
        return $this->redirect()->toRoute('eleve', ['action'=>'confirm']); 
    }
    
    public function confirmAction()
    {
      return new ViewModel();  
        
    }
    
    public function contactAction(){
        
        // Create the form.
        $form = new ContactForm();
        
         // Get croyant ID.
        $eleveId = (int)$this->params()->fromRoute('id', -1);
        
        // Validate input parameter
        if ($eleveId<0) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Find the existing croyant in the database.
        $eleve = $this->entityManager->getRepository(eleve::class)
                ->findOneById($eleveId);        
        if ($eleve == null) {
            $this->getResponse()->setStatusCode(404);
            return;                        
        } 
        
        
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
                $this->eleveManager->addContactToEleve($eleve, $data);
              
                // Go to the next step.
                return $this->redirect()->toRoute('eleve',['action'=>'view', 'id'=>$eleve->getId()]);
                // Redirect the user to "index" page.
            // return $this->redirect()->toRoute('croyant', ['action'=>'index']);
            }
        }
       
        // Render the view template.
        return new ViewModel([
            'form' => $form,
            'eleve'=>$eleve
        ]);
        
        
    }
    	
}