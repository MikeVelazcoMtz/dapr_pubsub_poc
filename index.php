<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

/**
 * Instantiate App
 *
 * In order for the factory to work you need to ensure you have installed
 * a supported PSR-7 implementation of your choice e.g.: Slim PSR-7 and a supported
 * ServerRequest creator (included with Slim PSR-7)
 * @var $app \Slim\App
 */
$app = AppFactory::create();

/**
 * The routing middleware should be added earlier than the ErrorMiddleware
 * Otherwise exceptions thrown from it will not be handled by the middleware
 */
$app->addRoutingMiddleware();

/**
 * Add Error Middleware
 *
 * @param bool                  $displayErrorDetails -> Should be set to false in production
 * @param bool                  $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool                  $logErrorDetails -> Display error details in error log
 * @param LoggerInterface|null  $logger -> Optional PSR-3 Logger
 *
 * Note: This middleware should be added last. It will not handle any exceptions/errors
 * for middleware added after it.
 */
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->get('/', function ($req, $response, $args) {
    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(
        json_encode([
            'msg' => 'hello'
        ])
    );

    return $response->withStatus(200);
});

$app->options('/', function ($req, $response, $args) {
    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(
        json_encode([
            'msg' => 'hello'
        ])
    );

    return $response->withStatus(200);
});

$app->options('/dapr/subscribe', function ($request, $response, $args) {
    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(
        json_encode([
            [
                'pubsubname' => 'php-subscriber',
                'topic' => 'topic1',
                'route' => 'orders'
                ]
        ], JSON_PRETTY_PRINT)
    );

    return $response->withStatus(200);
});

$app->get('/dapr/subscribe', function ($request, $response, $args) {
    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(
        json_encode([
            [
                'pubsubname' => 'php-subscriber',
                'topic' => 'topic1',
                'route' => 'orders'
                ]
        ], JSON_PRETTY_PRINT)
    );

    return $response->withStatus(200);
});


$app->options('/orders', function ($request, $response, $args) {
    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(
        json_encode([
           'message' => 'DAPR ENDPOINT CALLED'
        ], JSON_PRETTY_PRINT)
    );

    return $response->withStatus(200);
});

$app->post('/orders', function ($request, $response, $args) {
    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(
        json_encode([
           'message' => 'DAPR ENDPOINT CALLED'
        ], JSON_PRETTY_PRINT)
    );

    return $response->withStatus(200);
});


$app->run();
