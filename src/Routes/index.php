<?php

declare(strict_types=1);

use App\Controllers\SessionController;
use App\Controllers\UserController;
use App\Utils\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;

$app->get('/', function (Request $request, ResponseInterface $response) {
    $response = new Response($response, ['message' => 'Hello World!']);

    return $response->getResponse();
});

$app->post('/sessions/', SessionController::class.':auth')->setName('auth');

$app->post('/users/', UserController::class.':createUser')->setName('createUser');

// Protected Routes
$app->group('/api', function (RouteCollectorProxy $apiGroup) {
    // UsersRoutes
    require_once 'users.routes.php';
});
