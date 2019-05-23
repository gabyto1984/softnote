<?php
namespace Classeeleve;

use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'controllers' => [
        'factories' => [
            Controller\ClasseeleveController::class => InvokableFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'classeeleve' => [
                'type'    => Literal::class,
                'options' => [
                    // Change this to something specific to your module
                    'route'    => '/classeeleve',
                    'defaults' => [
                        'controller'    => Controller\ClasseeleveController::class,
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    // You can place additional routes that match under the
                    // route defined above here.
                ],
            ],
            'classeeleve' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/classeeleve[/:action]',
                    'defaults' => [
                        'controller'    => Controller\ClasseeleveController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
            
            'classeeleve' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/classeeleve[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller'    => Controller\ClasseeleveController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
            'configutation' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/classeeleve',
                    'defaults' => [
                        'controller' => Controller\ClasseeleveController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
             'classeeleve' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/classeeleve[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                    'constraints' =>[
                        'action'    => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ],
                    'defaults' => [
                        'controller' => Controller\ClasseeleveController::class,
                        'action'     => 'search',
                    ],
                ],
            ],
             'classeeleve' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/classeeleve[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                    'constraints' =>[
                        'action'    => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ],
                    'defaults' => [
                        'controller' => Controller\ClasseeleveController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    
    
    
     'access_filter' => [
        'controllers' => [
            Controller\ClasseeleveController::class => [
                // Give access to "resetPassword", "message" and "setPassword" actions
                // to anyone
                // Give access to "index", "add", "edit", "view", "changePassword" actions to authorized users only.
                ['actions' => ['index','classe','affecterEleve','affecterEleves','afficherEleves','add','edit','view','delete','confirm'], 'allow' => '+user.manage']
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
            Controller\ClasseeleveController::class => Controller\Factory\ClasseeleveControllerFactory::class
           
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\ClasseeleveManager::class => Service\Factory\ClasseeleveManagerFactory::class,
                         
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
