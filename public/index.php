<?php

/**
 * Moodle component registry.
 *
 * @author Luke Carrier <luke@carrier.im>
 * @copyright 2015 Luke Carrier
 * @license GPL v3
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Get the bootstrapped application
$app = require_once dirname(__DIR__) . '/etc/bootstrap.php';

// Register our routes
$app->get('/', function(Request $request) use($app) {
    $componentQuery = $app['orm.em']
        ->getRepository('ComponentRegistry\Entity\Component')
        ->createQueryBuilder('component')
        ->select('COUNT(component)')
        ->getQuery();
    $versionQuery = $app['orm.em']
        ->getRepository('ComponentRegistry\Entity\ComponentVersion')
        ->createQueryBuilder('version')
        ->select('COUNT(version)')
        ->getQuery();

    return $app['twig']->render('index.twig', [
        'numComponents' => $componentQuery->getSingleScalarResult(),
        'numVersions'   => $versionQuery->getSingleScalarResult(),
    ]);
});

$app->get('/components', function(Request $request) use($app) {
    $components = $app['orm.em']
        ->getRepository('ComponentRegistry\Entity\Component')
        ->findAll();

    return $app['twig']->render('components.twig', [
        'components' => $components,
    ]);
});

$app->get('/types', function(Request $request) use($app) {
    $types = $app['orm.em']
        ->getRepository('ComponentRegistry\Entity\Component');
    return $app['twig']->render('types.twig', $types);
});

// Serve the request
$app->run();
