<?php

$config = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$app = new \Slim\App($config);

// Fetch DI Container
$container = $app->getContainer();

// Register Twig view helper
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig('view/templates/', [
        //'cache' => 'path/to/cache'
    ]);

    // Instantiate and add Slim specific extension
    $router = $c->router;
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $view;
};