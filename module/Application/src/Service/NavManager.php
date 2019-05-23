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
            
             // Determine which items must be displayed in Administration function dropdown.
            $adminFunctionsDropdownItems = [];
            
            if ($this->rbacManager->isGranted(null, 'user.manage')) {
                $adminFunctionsDropdownItems[] = [
                            'id' => 'eleve',
                            'label' => 'Les Eleves',
                            'float' => 'left',
                            'link' => $url('eleve')
                        ];
                $adminFunctionsDropdownItems[] = [
                            'id' => 'classe',
                            'label' => 'Les Classes',
                            'float' => 'left',
                            'link' => $url('classe')
                        ];
                $adminFunctionsDropdownItems[] = [
                            'id' => 'matiere',
                            'label' => 'Les Matières',
                            'float' => 'left',
                            'link' => $url('matiere')
                        ];
            }
            
            if (count($adminFunctionsDropdownItems)!=0) {
                $items[] = [
                    'id' => 'administration',
                    'label' => 'Administration',
                    'dropdown' => $adminFunctionsDropdownItems
                ];
            }
            
            // Determine which items must be displayed in Configuration function dropdown.
            $ConfigurationFunctionsDropdownItems = [];
            
            if ($this->rbacManager->isGranted(null, 'user.manage')) {
                $ConfigurationFunctionsDropdownItems[] = [
                            'id' => 'enseignee',
                            'label' => 'Affectation matières',
                            'float' => 'left',
                            'link' => $url('enseignee')
                        ];
                 $ConfigurationFunctionsDropdownItems[] = [
                            'id' => 'classeeleve',
                            'label' => 'Affectation élèves',
                            'float' => 'left',
                            'link' => $url('classeeleve')
                        ];
                 
                 $ConfigurationFunctionsDropdownItems[] = [
                            'id' => 'anneescolaire',
                            'label' => 'Création Année Scolaire',
                            'float' => 'left',
                            'link' => $url('anneescolaire')
                        ];
                 
                 $ConfigurationFunctionsDropdownItems[] = [
                            'id' => 'periodeval',
                            'label' => 'Les périodes d\'évaluation ',
                            'float' => 'left',
                            'link' => $url('periodeval')
                        ];
            }
            
            
            if (count($ConfigurationFunctionsDropdownItems)!=0) {
                $items[] = [
                    'id' => 'configuration',
                    'label' => 'Configuration',
                    'dropdown' => $ConfigurationFunctionsDropdownItems
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
                        ]; $EvaluationsFunctionsDropdownItems[] = [
                            'id' => 'palmares',
                            'label' => 'Palmares bulletin',
                            'float' => 'left',
                            'link' => $url('palmares')
                        ]; $EvaluationsFunctionsDropdownItems[] = [
                            'id' => 'palmaresnotes',
                            'label' => 'Palmares notes',
                            'float' => 'left',
                            'link' => $url('palmaresnotes')
                        ]; 
               
            }
            if (count($EvaluationsFunctionsDropdownItems)!=0) {
                $items[] = [
                    'id' => 'evaluation',
                    'label' => 'Evaluation',
                    'dropdown' => $EvaluationsFunctionsDropdownItems
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


