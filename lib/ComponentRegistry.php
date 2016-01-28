<?php

/**
 * Moodle component registry.
 *
 * @author Luke Carrier <luke@carrier.im>
 * @copyright 2015 Luke Carrier
 * @license GPL v3
 */

namespace ComponentRegistry;

use Okeyaki\Silex\Provider\DoctrineMigrationsServiceProvider;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\TwigServiceProvider;

/**
 * Application entry point.
 */
class ComponentRegistry extends Application {
    /**
     * @override \Silex\Application
     */
    public function __construct($rootDir) {
        parent::__construct();

        // Doctrine DBAL
        $this->register(new DoctrineServiceProvider(), [
            'db.options' => [
                'driver' => 'pdo_sqlite',
                'path'   => $rootDir . '/db/dev.sqlite',
            ],
        ]);

        // Doctrine ORM
        $this->register(new DoctrineOrmServiceProvider(), [
            'orm.proxies_dir' => $rootDir . '/tmp/proxies',
            'orm.em.options'  => [
                'mappings' => [
                    [
                        'type'      => 'annotation',
                        'namespace' => 'ComponentRegistry\Entity',
                        'path'      => $rootDir . '/lib/Entity',
                    ]
                ],
            ],
        ]);

        // Doctrine schema migrations
        $this->register(new DoctrineMigrationsServiceProvider(), [
            'migrations.options' => [
                'default' => [
                    'namespace' => 'ComponentRegistry\Migrations',
                    'path'      => $rootDir . '/db/migrations',
                    'table'     => 'migrations',
                ],
            ],
        ]);

        // Twig templating
        $this->register(new TwigServiceProvider(), [
            'twig.path' => $rootDir . '/views',
        ]);
    }
}
