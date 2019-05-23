<?php
namespace Enseignee;

use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'controllers' => [
        'factories' => [
            Controller\EnseigneeController::class => InvokableFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'enseignee' => [
                'type'    => Literal::class,
                'options' => [
                    // Change this to something specific to your module
                    'route'    => '/enseignee',
                    'defaults' => [
                        'controller'    => Controller\EnseigneeController::class,
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    // You can place additional routes that match under the
                    // route defined above here.
                ],
            ],
            'enseignee' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/enseignee[/:action]',
                    'defaults' => [
                        'controller'    => Controller\EnseigneeController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
            
            'enseignee' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/enseignee[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller'    => Controller\EnseigneeController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
            'enseignee' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/enseignee',
                    'defaults' => [
                        'controller' => Controller\EnseigneeController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
             'enseignee' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/enseignee[/:action][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                    'constraints' =>[
                        'action'    => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ],
                    'defaults' => [
                        'controller' => Controller\EnseigneeController::class,
                        'action'     => 'search',
                    ],
                ],
            ],
             'enseignee' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/enseignee[/:action][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                    'constraints' =>[
                        'action'    => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ],
                    'defaults' => [
                        'controller' => Controller\EnseigneeController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    
    
    
     'access_filter' => [
        'controllers' => [
            Controller\EnseigneeController::class => [
                // Give access to "resetPassword", "message" and "setPassword" actions
                // to anyone
                // Give access to "index", "add", "edit", "view", "changePassword" actions to authorized users only.
                ['actions' => ['index', 'classe','add','edit','view','delete','confirm','affichermatiereclassee','desaffecter'], 'allow' => '+user.manage']
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
            Controller\EnseigneeController::class => Controller\Factory\EnseigneeControllerFactory::class
           
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\EnseigneeManager::class => Service\Factory\EnseigneeManagerFactory::class,
              
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
