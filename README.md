# Hello World!

This project is a REST Api skeleton using [Slim Framework 4](https://www.slimframework.com/docs/v4/) as framework, [Doctrine 2.8](https://www.doctrine-project.org/projects/doctrine-orm/en/2.8/reference/association-mapping.html#association-mapping) as ORM and JWT as security token authentication.

## The project

#### Routes

- [GET] / -> returns Hello World!
- [POST] /sessions -> login
- [POST] /users -> create a user

Authenticated routes.

- [GET] /api/users -> list all users
- [GET] /api/users/{id} -> return user by id
- [PUT] /api/users/{id} -> edit and return user
- [DELETE] /api/users/{id} -> delete user

#### Error handling

All throwed Exceptions returns a JSON:

```json
{
  "error": "Not found",
  "statusCode": 404
}
```

# Getting Started

## Requirements

- [Composer](https://getcomposer.org/)
- [PHP > 7](https://www.php.net/downloads)

#### Configuration

Rename **.env.example** file to **.env** and edit the variables.

## Dependencies

Using a terminal, open the root project folder.

Install project dependencies:

```bash
composer install
```

Create database tables

```bash
vendor/bin/doctrine orm:schema-tool:update --force
```

Server start

```bash
cd public

php -S http://localhost:8000
```

In the browser, use the url http://localhost:8000 and you'll have a JSON Hello World response.
