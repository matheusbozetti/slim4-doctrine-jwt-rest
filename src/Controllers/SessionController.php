<?php

namespace App\Controllers;

use App\Services\Session\LoginService;
use App\Utils\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SessionController
{
    private $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function auth(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = $request->getParsedBody();

        $loginUser = new LoginService($body, $this->container);
        $user = $loginUser->execute();

        $response = new Response(
            $response,
            $user
        );

        return $response->getResponse();
    }
}
