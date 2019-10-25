<?php
namespace Ecole\Form;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;
use Zend\InputFilter\FileInput;

/**
 * This form is used to collect requirement data.
 */
class EcoleForm extends Form
{
    
    /**
     * Constructor.     
     */
    
    public function __construct()
    {         
        // Define form name
        parent::__construct('ecole-form');
     
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
            'name' => 'nom',
            'attributes' => [
                    'id' => 'nom',
                 'style' => 'width: 50%'
            ],
            'options' => [
                'label' => 'Nom:',
            ],
        ]);
        
        // Add "adresse" field
        $this->add([        
            'type' => 'text',
            'name' => 'adresse',
            'attributes' => [
                    'id' => 'adresse',
                 'style' => 'width: 50%'
            ],
            'options' => [
                'label' => 'Adresse:',
            ],
        ]);
        
        // Add "adresse" field
        $this->add([        
            'type' => 'text',
            'name' => 'email',
            'attributes' => [
                    'id' => 'email',
                 'style' => 'width: 50%'
            ],
            'options' => [
                'label' => 'Email:',
            ],
        ]);
        
        // Add "telephones" field
        $this->add([        
            'type' => 'text',
            'name' => 'telephones',
            'attributes' => [
                    'id' => 'telephones',
                 'style' => 'width: 50%'
            ],
            'options' => [
                'label' => 'Téléphones:',
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
                'label' => 'Logo:',
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
                            'minWidth'  => 50,
                            'minHeight' => 50,
                            'maxWidth'  => 4096,
                            'maxHeight' => 4096
                        ]
                    ],                    
                ],
                'filters'  => [                    
                    [
                        'name' => 'FileRenameUpload',
                        'options' => [  
                            'target'=>'./public/img/upload/logo',
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