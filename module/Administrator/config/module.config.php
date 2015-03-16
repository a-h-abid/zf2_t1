<?php namespace Adminstrator;

return [
    
    'router' => [
        'routes' => [
            'administrator' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/admin',
                    'defaults' => [
                        '__NAMESPACE__' => 'Administrator\Controller',
                        'controller'    => 'Index',
                        'action'        => 'login',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'admin.dashboard' => [
                        'type'    => 'Literal',
                        'options' => [
                            'route'    => '/dashboard',
                            'defaults' => [
		                        '__NAMESPACE__' => 'Administrator\Controller',
		                        'controller'    => 'Index',
		                        'action'        => 'dashoboard',
		                    ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            'administrator' => __DIR__ . '/../view',
        ],
    ],

];