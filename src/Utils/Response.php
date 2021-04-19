<?php

declare(strict_types=1);

namespace App\Utils;

use \Psr\Http\Message\ResponseInterface;

class Response
{
    private ResponseInterface $response;

    /** @var mixed */
    private $data;

    private int $status;

    public function __construct($response, $data, int $status = 200)
    {
        $this->response = $response;
        $this->status = $status;
        $this->data = $data;
    }

    public function getResponse(): ResponseInterface
    {
        $this->response->getBody()->write(json_encode($this->data));

        return $this->response->withStatus($this->status)->withHeader('Content-type', 'application/json; charset=utf-8');
    }
}
