<?php

declare(strict_types=1);

namespace App\Models;

/**
 * @Entity
 * @HasLifecycleCallbacks
 * @Table(name="users")
 * */
class User extends Model
{
    /**
     * @Column(type="string")
     */
    private string $name;

    /**
     * @Column(type="string")
     * @Unique
     */
    private string $username;

    /**
     * @Column(type="string")
     * @Unique
     */
    private string $email;

    /**
     * @Column(type="string")
     */
    private string $password;

    public function __construct()
    {
        parent::__construct();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
