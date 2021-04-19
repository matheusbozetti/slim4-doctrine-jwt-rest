<?php

namespace App\Services\Session;

use App\Models\User;
use App\Utils\Error;
use Doctrine\ORM\EntityRepository;
use Firebase\JWT\JWT;
use Psr\Container\ContainerInterface;

class LoginService
{
    protected $container;
    protected $requestBody;
    protected EntityRepository $userRepository;

    // constructor receives container instance
    public function __construct($body, ContainerInterface $container)
    {
        $this->container = $container;
        $this->requestBody = $body;
        $this->userRepository = $container->get('em')->getRepository(\App\Models\User::class);
    }

    public function execute()
    {
        $user = $this->getUserByRequestBody();

        $secret_key = $_ENV['JWT_SECRET'];
        $issuedat_claim = time(); // issued at
        $notbefore_claim = $issuedat_claim + 60; //not before in seconds
        $expire_claim = $issuedat_claim + 86400; // expire time in seconds
        $token = [
            'iat' => $issuedat_claim,
            'nbf' => $notbefore_claim,
            'exp' => $expire_claim,
            'data' => [
                'id' => 'id',
                'email' => 'email',
            ], ];

        $jwt = JWT::encode($token, $secret_key);

        $object = (new class() extends \stdClass {
            /* @var string  */ public $jwt;
            /* @var \App\Models\User  */ public $user;
        });

        $object['jwt'] = $jwt;
        $object['user'] = $user;

        return $object;
    }

    protected function getUserByRequestBody(): User
    {
        $identifier = isset($this->requestBody['identifier']) ? $this->requestBody['identifier'] : null;
        $password = isset($this->requestBody['password']) ? $this->requestBody['password'] : null;

        if (!$identifier || !$password) {
            Error::invalidCredentials();
        }

        $userFromIdentifier = $this->getUserByEmailOrUsername($identifier);

        if (!$userFromIdentifier) {
            Error::invalidCredentials();
        }

        $user = array_shift($userFromIdentifier);

        if (!password_verify($password, $user->getPassword())) {
            Error::invalidCredentials();
        }

        return $user;
    }

    /** @return User[] */
    protected function getUserByEmailOrUsername(string $identifier): iterable
    {
        $queryBuilder = $this->container->get('em')->createQueryBuilder();

        return $queryBuilder
            ->select('u')
            ->from('\App\Models\User', 'u')
            ->where('u.email = :identifier')
            ->orWhere('u.username = :identifier')
            ->setMaxResults(1)
            ->setParameter('identifier', $identifier)
            ->getQuery()
            ->getResult()
        ;
    }
}
