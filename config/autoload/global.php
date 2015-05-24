<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [

    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => [
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'user'     => '',
                    'password' => '',
                    'dbname'   => '',
                    'prefix'   => '',
                ],
            ],
        ],
    ],

    'doctrine_factories' => [
        'entitymanager' => 'ABD\Factory\Service\EntityManagerFactory',
    ],

    'php-debug-bar' => [

        // Enables/disables PHP Debug Bar
        'enabled' => false,

        // ServiceManager keys to inject collectors
        // http://phpdebugbar.com/docs/data-collectors.html
        'collectors' => [],

        // ServiceManager key to inject storage
        // http://phpdebugbar.com/docs/storage.html
        'storage' => null,
    ],
    
];