<?php
namespace Eleve;

use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Application\Route\StaticRoute;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'controllers' => [
        'factories' => [
            Controller\EleveController::class => InvokableFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'eleve' => [
                'type'    => Literal::class,
                'options' => [
                    // Change this to something specific to your module
                    'route'    => '/eleve',
                    'defaults' => [
                        'controller'    => Controller\EleveController::class,
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    // You can place additional routes that match under the
                    // route defined above here.
                ],
            ],
            'eleve' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/eleve/:action]',
                    'defaults' => [
                        'controller'    => Controller\EleveController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
            
            'eleve' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/eleve[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller'    => Controller\EleveController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
            'eleve' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/eleve',
                    'defaults' => [
                        'controller' => Controller\EleveController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
             'eleve' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/eleve[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                    'constraints' =>[
                        'action'    => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ],
                    'defaults' => [
                        'controller' => Controller\EleveController::class,
                        'action'     => 'search',
                    ],
                ],
            ],
             'eleve' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/eleve[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                    'constraints' =>[
                        'action'    => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ],
                    'defaults' => [
                        'controller' => Controller\EleveController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            
        ],
    ],
     'access_filter' => [
        'controllers' => [
            Controller\EleveController::class => [
                // Give access to "resetPassword", "message" and "setPassword" actions
                // to anyone
                // Give access to "index", "add", "edit", "view", "changePassword" actions to authorized users only.
                ['actions' => ['index', 'afficherElevesParClasse','afficherElevesAdmis','eleve', 'search','add','edit','view','addEleve','contact','delete','confirm','file'], 'allow' => '+user.manage']
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
            Controller\EleveController::class => Controller\Factory\EleveControllerFactory::class
           
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\EleveManager::class => Service\Factory\EleveManagerFactory::class,
            Service\ImageManager::class => InvokableFactory::class,
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
