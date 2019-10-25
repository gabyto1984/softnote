<?php
namespace Test;

use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'controllers' => [
        'factories' => [
            Controller\TestController::class => InvokableFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'test' => [
                'type'    => Literal::class,
                'options' => [
                    // Change this to something specific to your module
                    'route'    => '/test',
                    'defaults' => [
                        'controller'    => Controller\TestController::class,
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    // You can place additional routes that match under the
                    // route defined above here.
                ],
            ],
            'test' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/test[/:action]',
                    'defaults' => [
                        'controller'    => Controller\TestController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
            
            'test' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/test[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller'    => Controller\TestController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
            'test' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/test',
                    'defaults' => [
                        'controller' => Controller\TestController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
             'test' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/test[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                    'constraints' =>[
                        'action'    => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ],
                    'defaults' => [
                        'controller' => Controller\TestController::class,
                        'action'     => 'search',
                    ],
                ],
            ],
             'test' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/test[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                    'constraints' =>[
                        'action'    => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ],
                    'defaults' => [
                        'controller' => Controller\TestController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    
    
    
     'access_filter' => [
        'controllers' => [
            Controller\TestController::class => [
                // Give access to "resetPassword", "message" and "setPassword" actions
                // to anyone
                // Give access to "index", "add", "edit", "view", "changePassword" actions to authorized users only.
                ['actions' => ['index', 'addpersonne','emprunter','addlivre','edit','viewemprunt','viewlivre','viewpersonne','delete','confirm'], 'allow' => '+user.manage']
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
            Controller\TestController::class => Controller\Factory\TestControllerFactory::class
           
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\LivreManager::class => Service\Factory\LivreManagerFactory::class,
            Service\PersonneManager::class => Service\Factory\PersonneManagerFactory::class, 
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
