<?php
namespace AnneeScolaire\Form;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;

/**
 * This form is used to collect requirement data.
 */
class AnneescolaireForm extends Form
{
    
    /**
     * Constructor.     
     */
    
    public function __construct()
    {         
        // Define form name
        parent::__construct('anneescolaire-form');
     
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
        
        // Add "statut" field
        $this->add([            
            'type'  => 'select',
            'name' => 'statut',
            'options' => [
                'label' => 'Statut:',
                'value_options' => [
                    1 => 'ACTIVE',
                    2 => 'PASSIVE'
                ]
            ],
            'attributes' => [
                'id' => 'statut',
                'style' => 'width: 50%'
            ],   
        ]);
        
        // Add "categorie" field
        $this->add([            
            'type'  => 'select',
            'name' => 'categorie',
            'options' => [
                'label' => 'Categorie:',
                'value_options' => [
                    1 => 'EN COURS',
                    2 => 'PASSEE'
                ]
            ],
            'attributes' => [
                'id' => 'categorie',
                'style' => 'width: 50%'
            ],   
        ]);
        
        // Add "categorie" field
        $this->add([        
            'type'  => 'textarea',
            'name' => 'commentaires',
            'options' =>[
                'label' => 'Commentaires:',
            ],
            'attributes' => [
                'id' => 'commentaires',
                'style' => 'width: 50%'
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