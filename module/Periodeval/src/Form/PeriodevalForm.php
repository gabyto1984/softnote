<?php
namespace Periodeval\Form;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;

/**
 * This form is used to collect requirement data.
 */
class PeriodevalForm extends Form
{
    
    /**
     * Scenario ('create' or 'update').
     * @var string 
     */
    private $scenario;
    
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager 
     */
    private $entityManager = null;
    
    /**
     * Current user.
     * @var Periodeval\Entity\Periodeval 
     */
    private $periodeval = null;
    
    /**
     * Constructor.     
     */
    
    public function __construct($scenario = 'create', $entityManager = null, $periodeval = null)
    {         
        // Define form name
        parent::__construct('periodeval-form');
        
         // Save parameters for internal use.
        $this->scenario = $scenario;
        $this->entityManager = $entityManager;
        $this->periodeval = $periodeval;
     
        // Set POST method for this form
        $this->setAttribute('method', 'post'); 
        $this->addElements();
        $this->addInputFilter(); 
    }
    
    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements() 
    {     
        // Add "libele" field
        $this->add([        
            'type' => 'text',
            'name' => 'description',
            'attributes' => [
                    'id' => 'description',
                 'style' => 'width: 100%'
            ],
            'options' => [
                'label' => 'Déscription:',
            ],
        ]);
        
        // Add "annee scolaire" field
         $this->add([        
            'type'  => 'select',
            'name' => 'anneescolaire',
            'options' => [
                'label' => 'Année Scolaire:',
                'empty_option' => 'Choisir',
                 'value_options' => [ 
                ],
            ],
            'attributes' => [
                'id' => 'anneescolaire',
                 'style' => 'width: 100%'
            ],
        ]);
        
        // Add "date_debut" field
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'date_debut',
            'create_empty_option' => false,
            'options' => [
                'label' => 'Date Début:',
                'create_empty_option' => false
                
                
            ],
            'attributes' => [
                'id' => 'date_debut',
                 'style' => 'width: 100%'
            ]      
        ));
        
        // Add "date_debut" field
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'date_fin',
            'create_empty_option' => false,
            'options' => [
                'label' => 'Date Fin:',
                'create_empty_option' => false
                ],
            'attributes' => [
                'id' => 'date_fin',
                 'style' => 'width: 100%'
            ]   
        ));
        
        // Add "periode decisionnelle" field
        
         $this->add([        
            'type'  => 'select',
            'name' => 'pdecisionnelle',
            'options' => [
                'label' => 'Type periode:',
                 'value_options' => [ 
                ],
            ],
            'attributes' => [
                'id' => 'pdecisionnelle',
                 'style' => 'width: 50%'
            ],
        ]);
       
        
        // Add "comment" field
        $this->add([        
            'type'  => 'textarea',
            'name' => 'commentaires',
            'options' =>[
                'label' => 'Commentaires:',
            ],
            'attributes' => [
                'id' => 'commentaires',
                'style' => 'width: 100%'
            ],   
        ]);
               
        // Add the submit button
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [                
                'value' => 'Enregistrer',
                'id' => 'submitbutton',
            ],
        ]);   
        
    }
     
    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter() 
    {
        
        $inputFilter = new InputFilter();        
        $this->setInputFilter($inputFilter);
        
        $inputFilter->add([
                'name'     => 'description',
                'required' => true,
                'filters'  => [
                    ['name' => 'StringTrim'],
                    ['name' => 'StripTags'],
                    ['name' => 'StripNewlines'],
                ],                
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 200
                        ],
                    ],
                ],
            ]);
        
        
        // Add input for "status" field
        $inputFilter->add([
                'name'     => 'anneescolaire',
                'required' => true,
                'filters'  => [                    
                    ['name' => 'ToInt'],
                ],                
                'validators' => [
                    ['name'=>'InArray', 'options'=>['haystack'=>[1, 2, 3, 4, 5, 6, 7, 8, 9]]]
                ],
            ]); 
      
    }
}