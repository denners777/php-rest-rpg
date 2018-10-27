<?php

$container = $app->getContainer();

$container['logger'] = function ($container) {
    $settings       = $container->get('settings')['logger'];
    $logger         = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $stream         = new Monolog\Handler\StreamHandler($settings['path'], $settings['level']);
    $fingersCrossed = new Monolog\Handler\FingersCrossedHandler($stream, Monolog\Logger::INFO);
    $logger->pushHandler($fingersCrossed);
    return $logger;
};

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container->get('settings')['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};
