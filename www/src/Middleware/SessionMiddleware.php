<?php

namespace Salle\LSCryptoNews\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SessionMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $response = $handler->handle($request);
        session_write_close();
        return $response;
    }
}