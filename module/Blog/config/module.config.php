<?php namespace Blog;

return [
    'controllers' => [
        'invokables' => [
            'Blog\Controller\Frontend\Blog' => 'Blog\Controller\Frontend\BlogController',
            'Blog\Controller\Backend\Blog' => 'Blog\Controller\Backend\BlogController',
        ],
    ],

    'router' => [
        'routes' => [
        	'administrator' => [
        		'child_routes' => [
        			'blog' => [
        				'type'		=> 'segment',
        				'options'	=> [
        					'route'    => '/blog[/:action][/:id]',
		                    'constraints' => [
		                        'controller' => 'Blog\Controller\Backend\Blog',
		                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
		                        'id'         => '[0-9]+',
		                    ],
		                    'defaults' => [
		                        'controller' => 'Blog\Controller\Backend\Blog',
		                        'action'     => 'index',
		                    ],
        				],
        			],
        		],
        	],
            'blog' => [
                'type'    => 'segment',
                'options' => [
                    'route'    => '/blog[/:action][/:id]',
                    'constraints' => [
                        'controller' => 'Blog\Controller\Frontend\Blog',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'         => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => 'Blog\Controller\Frontend\Blog',
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'blog' => __DIR__ . '/../view',
        ],
    ],

    // Doctrine config
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ],
            ],
        ],
    ],
];