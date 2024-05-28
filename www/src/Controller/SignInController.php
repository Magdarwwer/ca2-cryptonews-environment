<?php

namespace Salle\LSCryptoNews\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class SignInController
{
    private Twig $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    //    /**
//     * @throws SyntaxError
//     * @throws RuntimeError
//     * @throws LoaderError
//     */
    public function showSignInForm(Request $request, Response $response): Response
    {
        // Render sign-up form using Twig
        return $this->twig->render($response, 'sign-in.twig');
    }

    public function processSignIn(Request $request, Response $response): Response
    {
        // Retrieve the form data
        $formData = $request->getParsedBody();

        // Extract username and password from the form data
        $username = $formData['username'] ?? '';
        $password = $formData['password'] ?? '';

        // Validate the username and password (replace this with your actual validation logic)
        if ($this->validateCredentials($username, $password)) {
            // If credentials are valid, set user session variables and redirect to the home page
            $_SESSION['authenticated'] = true;
            $_SESSION['username'] = $username;
            return $response->withHeader('Location', '/');
        } else {
            // If credentials are invalid, render the sign-in form with an error message
            $error = 'Invalid username or password';
            return $this->twig->render($response, 'sign-in.twig', ['error' => $error]);
        }
    }

    // Validate username and password (replace this with your actual validation logic)
    private function validateCredentials($username, $password): bool
    {
        // Example validation logic: check if username and password are not empty
        return !empty($username) && !empty($password);
    }
}