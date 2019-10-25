<?php
namespace Test\Form;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;

/**
 * This form is used to collect requirement data.
 */
class LivreForm extends Form
{
    
    /**
     * Constructor.     
     */
    
    public function __construct()
    {         
        // Define form name
        parent::__construct('livre-form');
     
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
            'name' => 'titre',
            'attributes' => [
                    'id' => 'nom',
                 'style' => 'width: 50%'
            ],
            'options' => [
                'label' => 'Nom:',
            ],
        ]);
        
        // Add "prenom" field
        $this->add([        
            'type' => 'text',
            'name' => '',
            'attributes' => [
                    'id' => 'prenom',
                 'style' => 'width: 50%'
            ],
            'options' => [
                'label' => 'Prenom:',
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
                'name'     => 'nom',
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