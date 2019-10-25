<?php
namespace Evaluation;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'controllers' => [
        'factories' => [
            Controller\EvaluationController::class => InvokableFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'evaluation' => [
                'type'    => Literal::class,
                'options' => [
                    // Change this to something specific to your module
                    'route'    => '/evaluation',
                    'defaults' => [
                        'controller'    => Controller\EvaluationController::class,
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    // You can place additional routes that match under the
                    // route defined above here.
                ],
            ],
            'evaluation' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/evaluation[/:action]',
                    'defaults' => [
                        'controller'    => Controller\EvaluationController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
            
            'evaluation' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/evaluation[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller'    => Controller\EvaluationController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
            'evaluation' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/evaluation[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller'    => Controller\EvaluationController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
            'palmares' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/palmares',
                    'defaults' => [
                        'controller' => Controller\EvaluationController::class,
                        'action'     => 'palmares',
                    ],
                ],
            ],
            'palmaresnotes' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/palmaresnotes',
                    'defaults' => [
                        'controller' => Controller\EvaluationController::class,
                        'action'     => 'palmaresnotes',
                    ],
                ],
            ],
             'evaluation' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/evaluation[/:action][/:id][/:classe][/:periode][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                    'constraints' =>[
                        'action'    => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ],
                    'defaults' => [
                        'controller' => Controller\EvaluationController::class,
                        'action'     => 'search',
                    ],
                ],
            ],
             'evaluation' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/evaluation[/:action][/:id][/:classe][/:periode][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                    'constraints' =>[
                        'action'    => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ],
                    'defaults' => [
                        'controller' => Controller\EvaluationController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    
    
    
     'access_filter' => [
        'controllers' => [
            Controller\EvaluationController::class => [
                // Give access to "resetPassword", "message" and "setPassword" actions
                // to anyone
                // Give access to "index", "add", "edit", "view", "changePassword" actions to authorized users only.
                ['actions' => ['index', 'palmaresbulletins','imprimerPalmares','modifierNote','imprimerTous','afficherPalmaresNotes','eleveNonEvalue','afficherEleveMatiereClasse','afficherMatiereEvalueeClassePeriode','afficherPalmaresBulletin','palmaresnotes','afficherTotalCoef','afficherMatiereNotEvaluate','printpdf','palmares','imprimer','add','edit','view','delete','confirm','afficherMatiereClassee','desaffecter'], 'allow' => '+user.manage']
            ],
            //Controller\RegistrationController::class => [
                // Give access to "resetPassword", "message" and "setPassword" actions
                // to anyone
                // Give access to "index", "add", "edit", "view", "changePassword" actions to authorized users only.
               // ['actions' => ['index', 'review'], 'allow' => '+user.manage']
            //],
        ]
    ],
    'controllers' => [
        'factories' => [
            Controller\EvaluationController::class => Controller\Factory\EvaluationControllerFactory::class
           
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\EvaluationManager::class => Service\Factory\EvaluationManagerFactory::class,
              
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],  
     'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => ['ViewJsonStrategy',],
    ],
];
