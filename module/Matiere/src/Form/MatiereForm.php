<?php
namespace Matiere\Form;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;

/**
 * This form is used to collect requirement data.
 */
class MatiereForm extends Form
{
    
    /**
     * Constructor.     
     */
    
    public function __construct()
    {         
        // Define form name
        parent::__construct('matiere-form');
     
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
            'name' => 'libele_matiere',
            'attributes' => [
                    'id' => 'libele_matiere',
                 'style' => 'width: 50%'
            ],
            'options' => [
                'label' => 'libellé:',
            ],
        ]);
        
        // Add "abrege" field
        $this->add([        
            'type' => 'text',
            'name' => 'abrege',
            'attributes' => [
                    'id' => 'abrege',
                 'style' => 'width: 50%'
            ],
            'options' => [
                'label' => 'Abrégé:',
            ],
        ]);
        // Add "discipline" field
         $this->add([        
            'type'  => 'select',
            'name' => 'discipline',
            'options' => [
                'label' => 'Groupe matière:',
                 'value_options' => [ 
                ],
            ],
            'attributes' => [
                'id' => 'discipline',
                 'style' => 'width: 50%'
            ],
        ]);
        
        // Add "status" field
        $this->add([            
            'type'  => 'select',
            'name' => 'rang',
            'options' => [
                'label' => 'Rang:',
                'value_options' => [
                    0 => 'ORDINAIRE',
                    1 => 'BASE'
                ]
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
                'name'     => 'libele_matiere',
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
        
        $inputFilter->add([
                'name'     => 'abrege',
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
                            'max' => 4
                        ],
                    ],
                ],
            ]);
      
    }
}