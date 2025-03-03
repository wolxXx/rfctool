<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

// Autoloader
require __DIR__ . '/vendor/autoload.php';

// Create Container using PHP-DI
$containerBuilder = new ContainerBuilder();

// Add Container Definitions
$containerBuilder->addDefinitions([
    // Add any dependencies here, if required
]);

// Build Container
$container = $containerBuilder->build();

// Set App Factory Container
AppFactory::setContainer($container);

// Create App
$app = AppFactory::create();

// Define Routing Middleware
$app->addRoutingMiddleware();

// Error Middleware
$app->addErrorMiddleware(true, true, true);

// Define Routes
$app->get('/', \App\Action\HomeAction::class . ':handle');

// Run App
$app->run();