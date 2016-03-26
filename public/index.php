<?php

require '../vendor/autoload.php';

$app = new \Slim\App;
$container = $app->getContainer();

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('../templates'/*, [
        'cache' => '../cache'
    ]*/);
    
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    return $view;
};

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

$routers = glob('../routers/*.router.php');
foreach ($routers as $router) {
    require $router;
}

$app->run();
