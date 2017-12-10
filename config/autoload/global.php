<?php
declare(strict_types=1);

use Doctrine\DBAL\Driver\PDOMySql\Driver as PDOMySqlDriver;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'doctrine' => [
        'connection' => [
            // Configuration for service `doctrine.connection.orm_default` service
            'orm_default' => [
                'driverClass' => PDOMySqlDriver::class,
                // connection parameters, see
                // http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html
                'params' => [
                    'host' => 'localhost',
                    'port' => '3306',
                    'user' => 'root',
                    'password' => 'root',
                    'dbname' => 'practice',
                ],
            ],
        ],
    ],
];
