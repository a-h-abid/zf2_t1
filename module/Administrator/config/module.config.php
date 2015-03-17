<?php namespace Adminstrator;

return [
    
    'controllers' => [
        'invokables' => [
            'Administrator\Controller\Backend\Index' => 'Administrator\Controller\Backend\IndexController'
        ],
    ],

    'router' => [
        'routes' => [
            'administrator' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/admin',
                    'defaults' => [
                        'controller'    => 'Administrator\Controller\Backend\Index',
                        'action'        => 'login',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'dashboard' => [
                        'type'    => 'Literal',
                        'options' => [
                            'route'    => '/dashboard',
                            'defaults' => [
		                        'controller'    => 'Administrator\Controller\Backend\Index',
		                        'action'        => 'dashboard',
		                    ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'translator' => [
        'locale' => 'en_US',
        'translation_file_patterns' => [
            [
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ],
        ],
    ],

    'view_manager' => [
        'template_map' => [
            'admin/layout'		=> __DIR__ . '/../view/layout/layout.phtml',
            'admin/error/404'	=> __DIR__ . '/../view/error/404.phtml',
            'admin/index'		=> __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            'administrator' => __DIR__ . '/../view',
        ],
    ],

];