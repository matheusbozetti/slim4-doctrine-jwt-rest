<?php
declare(strict_types=1);

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use App\Utils\Response;

class ErrorHandlerMiddleware {

    protected $app;

    public function __construct($app) {
        $this->app = $app;
    }

    public function __invoke(ServerRequestInterface $request, Throwable $exception)
    {
        $statusCode = $exception->getCode() ? $exception->getCode() : 500;

        $response = $this->app->getResponseFactory()->createResponse();

        $errorResponse = new Response(
            $response,
            [
                'error' => $exception->getMessage(),
                'statusCode' => $statusCode
            ],
            $statusCode
        );

        return $errorResponse->getResponse();
    }
}
