<?php

use App\Middlewares\ErrorHandlerMiddleware;
use App\Utils\Response;
use Middlewares\TrailingSlash;
use Slim\App;

return function (App $app) {
    $settings = $app->getContainer()->get('settings');

    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    // Add Routing Middleware
    $app->addRoutingMiddleware();

    // Add TrailingSlash Middleware "/user/" will become "/user"
    $app->add(new TrailingSlash(true));

    // Add Custom Error Handler
    $customErrorHandler = new ErrorHandlerMiddleware($app);
    $errorMiddleware = $app->addErrorMiddleware(
        $settings['error']['displayErrorDetails'],
        $settings['error']['logErrors'],
        $settings['error']['logErrorDetails']
    );
    $errorMiddleware->setDefaultErrorHandler($customErrorHandler);

    // Add JWT security for " /api/* " routes
    $app->add(new \Tuupola\Middleware\JwtAuthentication([
        'path' => ['/api'], // or ["/api", "/admin"]
        'secret' => $_ENV['JWT_SECRET'],
        'error' => function ($response, $arguments) {
            $errorResponse = new Response(
                $response,
                [
                    'error' => $arguments['message'],
                    'statusCode' => $response->getStatusCode(),
                ],
                $response->getStatusCode()
            );

            return $errorResponse->getResponse();
        },
    ]));
};
