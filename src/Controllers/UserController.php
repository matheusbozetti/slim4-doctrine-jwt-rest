<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\User\CreateUserService;
use App\Services\User\UpdateUserService;
use App\Utils\Error;
use App\Utils\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserController
{
    private $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getUsers(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $userRepository = $this->container->get('em')->getRepository(User::class);
        $users = $userRepository->findAll() ?? [];

        $response = new Response(
            $response,
            ['users' => $users],
            200
        );

        return $response->getResponse();
    }

    public function getUserById(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $userId = isset($args['id']) ? $args['id'] : null;
        $userRepository = $this->container->get('em')->getRepository(User::class);

        $user = $userRepository->find($userId) ?? [];

        $response = new Response(
            $response,
            $user,
            200
        );

        return $response->getResponse();
    }

    public function deleteUser(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $userId = isset($args['id']) ? $args['id'] : null;

        $userRepository = $this->container->get('em')->getRepository(User::class);

        $user = $userRepository->find($userId) ?? null;

        if (!$user) {
            Error::userNotFound();
        }

        $this->container->get('em')->remove($user);
        $this->container->get('em')->flush();

        $response = new Response(
            $response,
            null,
            204
        );

        return $response->getResponse();
    }

    public function updateUser(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $userId = isset($args['id']) ? $args['id'] : null;

        $body = $request->getParsedBody();

        $updateUser = new UpdateUserService($body, $userId, $this->container);

        $user = $updateUser->execute();

        $response = new Response(
            $response,
            $user
        );

        return $response->getResponse();
    }

    public function createUser(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = $request->getParsedBody();

        $createdUser = new CreateUserService($body, $this->container);
        $user = $createdUser->execute();

        $response = new Response(
            $response,
            $user
        );

        return $response->getResponse();
    }
}
