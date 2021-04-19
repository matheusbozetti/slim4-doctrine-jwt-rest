<?php

namespace App\Services\User;

use App\Models\User;
use App\Utils\Error;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Psr\Container\ContainerInterface;

class CreateUserService
{
    protected ?string $name;
    protected ?string $email;
    protected ?string $username;
    protected ?string $password;

    protected EntityManager $db;
    protected EntityRepository $repository;

    public function __construct($user, ContainerInterface $container)
    {
        $this->name = isset($user['name']) ? $user['name'] : null;
        $this->email = isset($user['email']) ? $user['email'] : null;
        $this->username = isset($user['username']) ? $user['username'] : null;
        $this->password = isset($user['password']) ? $user['password'] : null;

        $this->db = $container->get('em');
        $this->repository = $container->get('em')->getRepository(User::class);
    }

    public function execute(): User
    {
        $user = new User();
        $user->setName($this->validateName($this->name));
        $user->setEmail($this->validateEmail($this->email));
        $user->setUsername($this->validateUsername($this->username));
        $user->setPassword($this->validatePassword($this->password));

        $this->db->persist($user);
        $this->db->flush();

        return $user;
    }

    protected function validateName(?string $name): string
    {
        if (!$name) {
            Error::requiredField('name');
        }

        return $name;
    }

    protected function validateUsername(?string $username): string
    {
        if (!$username) {
            Error::requiredField('username');
        }

        return $username;
    }

    protected function validatePassword(?string $password): string
    {
        if (!$password) {
            Error::requiredField('password');
        }

        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    protected function validateEmail(?string $email): string
    {
        if (!$email) {
            Error::requiredField('email');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Error::invalidFormat('email');
        }

        $getUserByEmail = $this->repository->findOneBy(['email' => $email]);

        if ($getUserByEmail) {
            Error::fieldUsed('email address');
        }

        return $email;
    }
}
