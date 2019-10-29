<?php
namespace Periodeval\Form;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;

/**
 * This form is used to collect requirement data.
 */
class PdecisionnelleForm extends Form
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
     * @var Periodeval\Entity\Pdecisionnelle 
     */
    private $pdecisionnelle = null;
    
    /**
     * Constructor.     
     */
    
    public function __construct($scenario = 'create', $entityManager = null, $pdecisionnelle = null)
    {         
        // Define form name
        parent::__construct('pdecisionnelle-form');
        
         // Save parameters for internal use.
        $this->scenario = $scenario;
        $this->entityManager = $entityManager;
        $this->pdecisionnelle = $pdecisionnelle;
     
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
            'name' => 'libele',
            'attributes' => [
                    'id' => 'libele',
                 'style' => 'width: 100%'
            ],
            'options' => [
                'label' => 'Libélé:',
            ],
        ]);
        
         
        // Add "type" field
        $this->add([            
            'type'  => 'select',
            'name' => 'type',
            'options' => [
                'label' => 'Type:',
                'value_options' => [
                    0 => 'ORDINAIRE',
                    1 => 'DECISIONELLE'
                ]
            ],
        ]);
        
               
        // Add the submit button
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [                
                'value' => 'Enregistrer',
                'id' => 'submitbuttonpdecisionnelle',
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
                'name'     => 'libele',
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
      
    }
}