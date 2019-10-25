<?php
namespace Evaluation\Form;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;

/**
 * This form is used to collect requirement data.
 */
class PalmaresbulletinsForm extends Form
{
    
    /**
     * Constructor.     
     */
    
    public function __construct()
    {         
        // Define form name
        parent::__construct('palmaresbulletins-form');
     
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
            'name' => 'anneescolaire',
            'attributes' => [
                    'id' => 'anneescolaire'
            ],
            'options' => [
                'label' => 'Année scolaire:',
            ],
        ]);
        
       // Add "annee scolaire" field
         $this->add([        
            'type'  => 'select',
            'name' => 'periodeval',
            'options' => [
                'label' => 'Période:',
                'empty_option' => 'Choisir',
                 'value_options' => [ 
                ],
            ],
            'attributes' => [
                'id' => 'petriodeval'
            ],
        ]);
         
         // Add "annee scolaire" field
         $this->add([        
            'type'  => 'select',
            'name' => 'classe',
            'options' => [
                'label' => 'Classe:',
                'empty_option' => 'Choisir',
                 'value_options' => [ 
                ],
            ],
            'attributes' => [
                'id' => 'classe'
            ],
        ]);
         
       
        // Add the submit button
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [                
                'value' => 'Imprimer palmares',
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
                'name'     => 'annescolaire',
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