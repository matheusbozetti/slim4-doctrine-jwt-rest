<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('/users', function (RouteCollectorProxy $usersRoute) {
        $usersRoute->get('/', UserController::class.':getUsers')->setName('getUsers');

        $usersRoute->get('/{id}/', UserController::class.':getUserById')->setName('getUserById');
        $usersRoute->put('/{id}/', UserController::class.':updateUser')->setName('updateUser');
        $usersRoute->delete('/{id}/', UserController::class.':deleteUser')->setName('deleteUser');
    });
};
