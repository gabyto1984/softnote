<?php
namespace Application\Service;

/**
 * This service is responsible for determining which items should be in the main menu.
 * The items may be different depending on whether the user is authenticated or not.
 */
class NavManager
{
    /**
     * Auth service.
     * @var Zend\Authentication\Authentication
     */
    private $authService;
    
    /**
     * Url view helper.
     * @var Zend\View\Helper\Url
     */
    private $urlHelper;
    
    /**
     * RBAC manager.
     * @var User\Service\RbacManager
     */
    private $rbacManager;
    
    /**
     * Constructs the service.
     */
    public function __construct($authService, $urlHelper, $rbacManager) 
    {
        $this->authService = $authService;
        $this->urlHelper = $urlHelper;
        $this->rbacManager = $rbacManager;
    }
    
    /**
     * This method returns menu items depending on whether user has logged in or not.
     */
    public function getMenuItems() 
    {
        $url = $this->urlHelper;
        $items = [];
        
        $items[] = [
            'id' => 'home',
            'label' => 'Accueil',
            'link'  => $url('home')
        ];
    
        // Display "Login" menu item for not authorized user only. On the other hand,
        // display "Admin" and "Logout" menu items only for authorized users.
        if (!$this->authService->hasIdentity()) {
            $items[] = [
                'id' => 'login',
                'label' => 'Sign in',
                'link'  => $url('login'),
                'float' => 'right'
            ];
        } else {
            
            // Determine which items must be displayed in Admin dropdown.
            $adminDropdownItems = [];
            
            if ($this->rbacManager->isGranted(null, 'user.manage')) {
                $adminDropdownItems[] = [
                            'id' => 'users',
                            'label' => 'Manage Users',
                            'link' => $url('users')
                        ];
            }
            
            if ($this->rbacManager->isGranted(null, 'permission.manage')) {
                $adminDropdownItems[] = [
                            'id' => 'permissions',
                            'label' => 'Manage Permissions',
                            'link' => $url('permissions')
                        ];
            }
            
            if ($this->rbacManager->isGranted(null, 'role.manage')) {
                $adminDropdownItems[] = [
                            'id' => 'roles',
                            'label' => 'Manage Roles',
                            'link' => $url('roles')
                        ];
            }
                        
            if (count($adminDropdownItems)!=0) {
                $items[] = [
                    'id' => 'admin',
                    'label' => 'Admin',
                    'float' => 'right',
                    'dropdown' => $adminDropdownItems
                ];
            }
            
            $StructureDeBaseDropdownItems = [];
            
            if ($this->rbacManager->isGranted(null, 'user.manage')) {
                
                $StructureDeBaseDropdownItems[] = [
                            'id' => 'salle',
                            'label' => 'Les Salles',
                            'float' => 'left',
                            'link' => $url('salle')
                        ];
                 
                $StructureDeBaseDropdownItems[] = [
                            'id' => 'eleve',
                            'label' => 'Les élèves',
                            'float' => 'left',
                            'link' => $url('eleve')
                        ];
               
                $StructureDeBaseDropdownItems[] = [
                            'id' => 'matiere',
                            'label' => 'Les Matières',
                            'float' => 'left',
                            'link' => $url('matiere')
                        ];
                
                 $StructureDeBaseDropdownItems[] = [
                            'id' => 'periodeval',
                            'label' => 'Les périodes d\'évaluation ',
                            'float' => 'left',
                            'link' => $url('periodeval')
                        ];
               
            }
            if (count($StructureDeBaseDropdownItems)!=0) {
                $items[] = [
                    'id' => 'structure_de_base',
                    'label' => 'Structure de base',
                    'dropdown' => $StructureDeBaseDropdownItems
                ];
            }
            
             // Determine which items must be displayed in Administration function dropdown.
            $paramFunctionsDropdownItems = [];
            
            if ($this->rbacManager->isGranted(null, 'user.manage')) {
                
                $paramFunctionsDropdownItems[] = [
                            'id' => 'ecole',
                            'label' => 'Création Ecòle',
                            'link' => $url('ecole')
                        ];
                                
               $paramFunctionsDropdownItems[] = [
                            'id' => 'anneescolaire',
                            'label' => 'Création Année Scolaire',
                            'float' => 'left',
                            'link' => $url('anneescolaire')
                        ];
               $paramFunctionsDropdownItems[] = [
                            'id' => 'attestation',
                            'label' => 'Attestations',
                            'float' => 'left',
                            //'link' => $url('anneescolaire')
                        ];
               $paramFunctionsDropdownItems[] = [
                            'id' => 'parametreBulletin',
                            'label' => 'Formatage bulletin',
                            'float' => 'left',
                            //'link' => $url('anneescolaire')
                        ];
               $paramFunctionsDropdownItems[] = [
                            'id' => 'backup',
                            'label' => 'Backup du systeme',
                            'float' => 'left',
                            //'link' => $url('anneescolaire')
                        ];
               
               
            }
            
            if (count($paramFunctionsDropdownItems)!=0) {
                $items[] = [
                    'id' => 'administration',
                    'label' => 'Paramètre',
                    'dropdown' => $paramFunctionsDropdownItems
                ];
            }
            
            // Determine which items must be displayed in Configuration function dropdown.
            $suiviClasseFunctionsDropdownItems = [];
            
            if ($this->rbacManager->isGranted(null, 'user.manage')) {
                
                $suiviClasseFunctionsDropdownItems[] = [
                            'id' => 'classe',
                            'label' => 'Les Classes',
                            'float' => 'left',
                            'link' => $url('classe')
                        ];
                $suiviClasseFunctionsDropdownItems[] = [
                            'id' => 'badge',
                            'label' => 'Badges',
                            'float' => 'left',
                            //'link' => $url('classe')
                        ];
                
                  $suiviClasseFunctionsDropdownItems[] = [
                            'id' => 'matiere',
                            'label' => 'Affecter matiere',
                            'float' => 'left',
                            'link' => $url('matiere', ['action'=>'affecter'])
                        ];
                                
                $suiviClasseFunctionsDropdownItems[] = [
                            'id' => 'classe',
                            'label' => 'Rentrée des classes',
                            'float' => 'left',
                            'link' => $url('classe', ['action'=>'configurer'])
                        ];
                                                   
                $suiviClasseFunctionsDropdownItems[] = [
                            'id' => 'test',
                            'label' => 'Tester',
                            'float' => 'left',
                            'link' => $url('test')
                        ];
            }
            
            
            if (count($suiviClasseFunctionsDropdownItems)!=0) {
                $items[] = [
                    'id' => 'configuration',
                    'label' => 'Suivi par Classe',
                    'dropdown' => $suiviClasseFunctionsDropdownItems
                ];
            }
            
             // Determine which items must be displayed in Configuration function dropdown.
            $EvaluationsFunctionsDropdownItems = [];
            if ($this->rbacManager->isGranted(null, 'user.manage')) {
               $EvaluationsFunctionsDropdownItems[] = [
                            'id' => 'evaluation',
                            'label' => 'Saisir note',
                            'float' => 'left',
                            'link' => $url('evaluation')
                        ]; 
               
               $EvaluationsFunctionsDropdownItems[] = [
                            'id' => 'palmaresnotes',
                            'label' => 'Palmares notes',
                            'float' => 'left',
                            'link' => $url('palmaresnotes')
                        ]; 
               
               $EvaluationsFunctionsDropdownItems[] = [
                            'id' => 'evaluation',
                            'label' => 'Palmares bulletins',
                            'float' => 'left',
                            'link' => $url('evaluation', ['action'=>'palmaresbulletins'])
                        ]; 
               $EvaluationsFunctionsDropdownItems[] = [
                            'id' => 'palmares',
                            'label' => 'Palmares & Impression bulletin',
                            'float' => 'left',
                            'link' => $url('palmares')
                        ]; 
            }
            if (count($EvaluationsFunctionsDropdownItems)!=0) {
                $items[] = [
                    'id' => 'evaluation',
                    'label' => 'Evaluation',
                    'dropdown' => $EvaluationsFunctionsDropdownItems
                ];
            }
            
            $rapportsFunctionsDropdownItems = [];
            
            if ($this->rbacManager->isGranted(null, 'user.manage')) {
                
                $rapportsFunctionsDropdownItems[] = [
                            'id' => 'rapport',
                            'label' => 'Fueille de presence',
                            'float' => 'left',
                            //'link' => $url('classe')
                        ];
            }
            if (count($rapportsFunctionsDropdownItems)!=0) {
                $items[] = [
                    'id' => 'rapport',
                    'label' => 'Rapports',
                    'dropdown' => $rapportsFunctionsDropdownItems
                ];
            }
            $archiveFunctionsDropdownItems = [];
            
            if ($this->rbacManager->isGranted(null, 'user.manage')) {
                
                $archiveFunctionsDropdownItems[] = [
                            'id' => 'archiveAnnuel',
                            'label' => 'Archive par annee',
                            'float' => 'left',
                            //'link' => $url('classe')
                        ];
            }
            if (count($archiveFunctionsDropdownItems)!=0) {
                $items[] = [
                    'id' => 'archive',
                    'label' => 'Archive',
                    'dropdown' => $archiveFunctionsDropdownItems
                ];
            }
            
            $items[] = [
                'id' => 'logout',
                'label' => $this->authService->getIdentity(),
                'float' => 'right',
                'dropdown' => [
                    [
                        'id' => 'settings',
                        'label' => 'Settings',
                        'link' => $url('application', ['action'=>'settings'])
                    ],
                    [
                        'id' => 'logout',
                        'label' => 'Sign out',
                        'link' => $url('logout')
                    ],
                ]
            ];
            
            
           
        }
        
        return $items;
    }
}


