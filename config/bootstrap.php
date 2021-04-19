<?php

error_reporting(E_ALL);
date_default_timezone_set('America/Sao_Paulo');

set_error_handler(function ($severity, $message, $file, $line) {
    if (error_reporting() & $severity) {
        throw new \ErrorException($message, 0, $severity, $file, $line);
    }
});

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR);
$dotenv->load();

$containerBuilder = new ContainerBuilder();

// definindo as configuracoes no container
$settings = require __DIR__.DIRECTORY_SEPARATOR.'settings.php';
$containerBuilder->addDefinitions($settings);

$container = $containerBuilder->build();

// inserindo o entity manager no container
require __DIR__.DIRECTORY_SEPARATOR.'doctrine.php';
$entityManager = getEntityManager($container);
$container->set('em', $entityManager);

$app = AppFactory::createFromContainer($container);

$middleware = require __DIR__.DIRECTORY_SEPARATOR.'middleware.php';
$middleware($app);

require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Routes'.DIRECTORY_SEPARATOR.'index.php';
