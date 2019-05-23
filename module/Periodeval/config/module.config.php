<?php
namespace Periodeval;

use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'controllers' => [
        'factories' => [
            Controller\PeriodevalController::class => InvokableFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'periodeval' => [
                'type'    => Literal::class,
                'options' => [
                    // Change this to something specific to your module
                    'route'    => '/matiere',
                    'defaults' => [
                        'controller'    => Controller\PeriodevalController::class,
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    // You can place additional routes that match under the
                    // route defined above here.
                ],
            ],
            'periodeval' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/periodeval[/:action]',
                    'defaults' => [
                        'controller'    => Controller\PeriodevalController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
            
            'periodeval' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/periodeval[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller'    => Controller\PeriodevalController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
            'periodeval' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/periodeval',
                    'defaults' => [
                        'controller' => Controller\PeriodevalController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
             'periodeval' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/periodeval[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                    'constraints' =>[
                        'action'    => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ],
                    'defaults' => [
                        'controller' => Controller\PeriodevalController::class,
                        'action'     => 'search',
                    ],
                ],
            ],
             'periodeval' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/periodeval[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                    'constraints' =>[
                        'action'    => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ],
                    'defaults' => [
                        'controller' => Controller\PeriodevalController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    
    
    
     'access_filter' => [
        'controllers' => [
        Controller\PeriodevalController::class => [
                // Give access to "resetPassword", "message" and "setPassword" actions
                // to anyone
                // Give access to "index", "add", "edit", "view", "changePassword" actions to authorized users only.
                ['actions' => ['index','add','edit','view','delete','deleted','confirm','viewd'], 'allow' => '+user.manage']
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
        Controller\PeriodevalController::class => Controller\Factory\PeriodevalControllerFactory::class
           
        ],
    ],
    'service_manager' => [
        'factories' => [
        Service\PeriodevalManager::class => Service\Factory\PeriodevalManagerFactory::class,
              
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
