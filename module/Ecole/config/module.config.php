<?php
namespace Ecole;

use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'controllers' => [
        'factories' => [
            Controller\EcoleController::class => InvokableFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'ecole' => [
                'type'    => Literal::class,
                'options' => [
                    // Change this to something specific to your module
                    'route'    => '/ecole',
                    'defaults' => [
                        'controller'    => Controller\EcoleController::class,
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    // You can place additional routes that match under the
                    // route defined above here.
                ],
            ],
            'ecole' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/ecole[/:action]',
                    'defaults' => [
                        'controller'    => Controller\EcoleController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
            
            'ecole' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/ecole[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller'    => Controller\EcoleController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
            'ecole' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/ecole',
                    'defaults' => [
                        'controller' => Controller\EcoleController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
             'ecole' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/ecole[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                    'constraints' =>[
                        'action'    => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ],
                    'defaults' => [
                        'controller' => Controller\EcoleController::class,
                        'action'     => 'search',
                    ],
                ],
            ],
             'ecole' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/ecole[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                    'constraints' =>[
                        'action'    => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ],
                    'defaults' => [
                        'controller' => Controller\EcoleController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    
    
    
     'access_filter' => [
        'controllers' => [
            Controller\EcoleController::class => [
                // Give access to "resetPassword", "message" and "setPassword" actions
                // to anyone
                // Give access to "index", "add", "edit", "view", "changePassword" actions to authorized users only.
                ['actions' => ['index', 'ecole','ajouter','edit','view','delete','confirm'], 'allow' => '+user.manage']
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
            Controller\EcoleController::class => Controller\Factory\EcoleControllerFactory::class
           
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\EcoleManager::class => Service\Factory\EcoleManagerFactory::class,
              
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
