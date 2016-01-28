<?php

/**
 * Moodle component registry.
 *
 * @author Luke Carrier <luke@carrier.im>
 * @copyright 2015 Luke Carrier
 * @license GPL v3
 */

use ComponentRegistry\ComponentRegistry;
use ComponentRegistry\PackageRepository\MoodlePackageRepository;

// Configure the PHP environment
error_reporting(E_ALL);
ini_set('display_errors', 'On');
date_default_timezone_set(@date_default_timezone_get());

// Initialise class autoloading
require_once dirname(__DIR__) . '/vendor/autoload.php';

// Initialise the container
$app = new ComponentRegistry(dirname(__DIR__));
$app['debug']         = true;
$app['cr.wwwRoot']    = '/';
$app['cr.dispatcher'] = 'index.php';

// Configure package repositories to synchronise
$app['cr.package_repositories'] = [
    new MoodlePackageRepository(),
];

return $app;
