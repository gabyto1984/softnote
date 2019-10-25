<?php
namespace Eleve\Form;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;
use Zend\InputFilter\FileInput;

/**
 * This form is used to collect post data.
 */
class EleveForm extends Form
{
    
    /**
     * Constructor.     
     */
   
    
    public function __construct()
    {         
        // Define form name
        parent::__construct('eleve-form');
     
        // Set POST method for this form
        $this->setAttribute('method', 'post'); 
        // Set binary content encoding
        $this->setAttribute('enctype', 'multipart/form-data'); 
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
            'name' => 'nom_eleve',
            'attributes' => [
                    'id' => 'nom_eleve',
                 'style' => 'width: 50%'
            ],
            'options' => [
                'label' => 'Nom:',
            ],
        ]);
        
        // Add "prenom" field
        $this->add([        
            'type' => 'text',
            'name' => 'prenom_eleve',
            'attributes' => [
                    'id' => 'prenom_eleve',
                 'style' => 'width: 50%'
            ],
            'options' => [
                'label' => 'Prénom:',
            ],
        ]);
        
         // Add "date_debut" field
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'date_naissance',
            'create_empty_option' => false,
            'options' => array(
                'label' => 'Date Naissance:',
                'create_empty_option' => false
                
                
            )
        ));
        
        
         // Add "lieu Naissance" field
        $this->add([        
            'type' => 'text',
            'name' => 'lieu_naissance',
            'attributes' => [
                    'id' => 'lieu_naissance',
                 'style' => 'width: 50%'
            ],
            'options' => [
                'label' => 'Lieu Naissance:',
            ],
        ]);
        
         // Add "category" field
        $this->add([            
            'type'  => 'select',
            'name' => 'sexe',
            'options' => [
                'label' => 'Sexe:',
                'value_options' => [
                    1 => 'FEMININ',
                    2 => 'MASCULIN', 
                    3 => 'AUTRE'
                ]
            ],
        ]);
        
        // Add "code eleve " field
        $this->add([        
            'type' => 'text',
            'name' => 'code_eleve',
            'attributes' => [
                    'id' => 'code_eleve',
                 'style' => 'width: 50%'
            ],
            'options' => [
                'label' => 'Code:',
            ],
        ]);
        
        // Add "status" field
        $this->add([            
            'type'  => 'select',
            'name' => 'statut',
            'options' => [
                'label' => 'Statut:',
                'value_options' => [
                    0 => 'INSCRIT',
                    1 => 'ACTIF',
                    2 => 'ADMIS',
                    3 => 'TERMINE', 
                    4 => 'EXPULSE'
                ]
            ],
        ]);
        
        // Add "code eleve " field
        $this->add([        
            'type' => 'text',
            'name' => 'email',
            'attributes' => [
                    'id' => 'email',
                 'style' => 'width: 50%'
            ],
            'options' => [
                'label' => 'E-mail:',
            ],
        ]);
              
        // Add "file" field
        $this->add([
            'type'  => 'file',
            'name' => 'file',
            'attributes' => [               
                'id' => 'file'
            ],
            'options' => [
                'label' => 'Photo:',
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
                'name'     => 'nom_eleve',
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
                            'max' => 1024
                        ],
                    ],
                ],
            ]);
        
        $inputFilter->add([
                'name'     => 'prenom_eleve',
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
                            'max' => 1024
                        ],
                    ],
                ],
            ]);
        
         // Add validation rules for the "file" field	 
        $inputFilter->add([
                'type'     => FileInput::class,
                'name'     => 'file',
                'required' => false,                           
                'validators' => [
                    ['name'    => 'FileUploadFile'],
                    [
                        'name'    => 'FileMimeType',                        
                        'options' => [                            
                            'mimeType'  => ['image/jpeg', 'image/png']
                        ]
                    ],
                    ['name'    => 'FileIsImage'],                          
                    [
                        'name'    => 'FileImageSize',                        
                        'options' => [                            
                            'minWidth'  => 120,
                            'minHeight' => 100,
                            'maxWidth'  => 4096,
                            'maxHeight' => 4096
                        ]
                    ],                    
                ],
                'filters'  => [                    
                    [
                        'name' => 'FileRenameUpload',
                        'options' => [  
                            'target'=>'./public/img/upload',
                            'useUploadName'=>true,
                            'useUploadExtension'=>true,
                            'overwrite'=>true,
                            'randomize'=>false
                        ]
                    ]
                ],     
            ]);        
        
        
    }
}