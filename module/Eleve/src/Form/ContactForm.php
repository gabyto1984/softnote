<?php
namespace Eleve\Form;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;
use Zend\InputFilter\FileInput;

/**
 * This form is used to collect post data.
 */
class ContactForm extends Form
{
    
    /**
     * Constructor.     
     */
   
    
    public function __construct()
    {         
        // Define form name
        parent::__construct('contact-form');
     
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
        // Add "nom" field
        $this->add([        
            'type' => 'text',
            'name' => 'nom_parent',
            'attributes' => [
                    'id' => 'nom_parent',
                 'style' => 'width: 50%'
            ],
            'options' => [
                'label' => 'Nom de famille:',
            ],
        ]);
        
        // Add "prenom" field
        $this->add([        
            'type' => 'text',
            'name' => 'prenom_parent',
            'attributes' => [
                    'id' => 'prenom_parent',
                 'style' => 'width: 50%'
            ],
            'options' => [
                'label' => 'Prénom parent:',
            ],
        ]);
        
        // Add "domicile" field
        $this->add([        
            'type' => 'text',
            'name' => 'domicile',
            'attributes' => [
                    'id' => 'domicile',
                 'style' => 'width: 50%'
            ],
            'options' => [
                'label' => 'Domicile:',
            ],
        ]);
        
         // Add "telephone_number" field
        $this->add([           
            'type'  => 'text',
            'name' => 'telephone1',
            'attributes' => [
                'id' => 'telephone1'
            ],
            'options' => [
                'label' => 'Téléphone 1',
            ],
        ]);
        
        // Add "telephone_number" field
        $this->add([           
            'type'  => 'text',
            'name' => 'telephone2',
            'attributes' => [
                'id' => 'telephone2'
            ],
            'options' => [
                'label' => 'Téléphone 2',
            ],
        ]);
        
        // Add "code eleve " field
        $this->add([        
            'type' => 'text',
            'name' => 'email_parent',
            'attributes' => [
                    'id' => 'email_parent',
                 'style' => 'width: 50%'
            ],
            'options' => [
                'label' => 'E-mail:',
            ],
        ]);
              
       // Add "comment" field
        $this->add([        
            'type'  => 'textarea',
            'name' => 'commentaire',
            'options' =>[
                'label' => 'Commentaires:',
            ],
            'attributes' => [
                'id' => 'commentaire',
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
                'name'     => 'nom_parent',
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
                            'min' => 2,
                            'max' => 100
                        ],
                    ],
                ],
            ]);
        
        $inputFilter->add([
                'name'     => 'prenom_parent',
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
                            'min' => 2,
                            'max' => 100
                        ],
                    ],
                ],
            ]);
        
        $inputFilter->add([
                    'name'     => 'email_parent',
                    'required' => true,
                    'filters'  => [
                        ['name' => 'StringTrim'],                    
                    ],                
                    'validators' => [
                        [
                            'name' => 'EmailAddress',
                            'options' => [
                                'allow' => \Zend\Validator\Hostname::ALLOW_DNS,
                                'useMxCheck'    => false,                            
                            ],
                        ],
                    ],
                ]);
        
    }
}