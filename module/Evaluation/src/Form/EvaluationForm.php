<?php
namespace Evaluation\Form;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;

/**
 * This form is used to collect requirement data.
 */
class EvaluationForm extends Form
{
    
    /**
     * Constructor.     
     */
    
    public function __construct()
    {         
        // Define form name
        parent::__construct('evaluation-form');
     
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
                 'style' => 'width: 50%'
            ],
            'options' => [
                'label' => 'libellé:',
            ],
        ]);
        
        // Add "libele" field
        $this->add([        
            'type' => 'text',
            'name' => 'numero',
            'attributes' => [
                    'id' => 'numero',
                 'style' => 'width: 50%'
            ],
            'options' => [
                'label' => 'Numéro:',
            ],
        ]);
        
        // Add "libele" field
        $this->add([        
            'type' => 'text',
            'name' => 'quantite',
            'attributes' => [
                    'id' => 'quantite',
                 'style' => 'width: 50%'
            ],
            'options' => [
                'label' => 'Quantité:',
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