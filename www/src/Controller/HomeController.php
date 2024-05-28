<?php

namespace Salle\LSCryptoNews\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class HomeController
{
    private Twig $twig;


    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function showHome(Request $request, Response $response): Response
    {
        // Render sign-up form using Twig
        return $this->twig->render($response, 'home.twig');
    }


}