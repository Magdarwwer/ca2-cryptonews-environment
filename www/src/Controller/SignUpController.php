<?php

namespace Salle\LSCryptoNews\Controller;

use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Salle\LSCryptoNews\model\User;
use Salle\LSCryptoNews\model\UserRepository;
use Slim\Views\Twig;


class SignUpController
{
    private Twig $twig;
    private UserRepository $userRepository;

    public function __construct(Twig $twig, UserRepository $userRepository)
    {
        $this->twig = $twig;
        $this->userRepository = $userRepository;
    }

    public function showSignUpForm(Request $request, Response $response): Response
    {
        // Render sign-up form using Twig
        return $this->twig->render($response, 'sign-up.twig');
    }


    public function processSignUp(Request $request, Response $response): Response
    {
        $formData = $request->getParsedBody();

        // Perform validation
        $errors = $this->validateSignUpForm($formData);

        if (empty($errors)) {

            $user = new User($formData['email'], $formData['password'], $formData['numBitcoins']);

            try {
                // Save the user using the repository
                $this->userRepository->save($user);
            } catch (Exception $e) {
                $errors['database'] = 'An error occurred while saving user data.';
                $responseBody = [
                    'errors' => $errors,
                    'data' => $formData
                ];

                $response->getBody()->write(json_encode($responseBody));
                return $response;
            }

            $userData = [
                'email' => $user->getEmail(),
                'numBitcoins' => $user->getCoins(),
            ];
            $responseBody = [
                'message' => 'User created successfully',
                'data' => $userData
            ];

            $response->getBody()->write(json_encode($responseBody));


            return $response->withHeader('Location', '/login');
            //header('Location: login.php');
            // exit;

            //return $response->withHeader('Location', '/login');
        } else {
            // If errors, return to sign-up form with errors and form data
            return $this->twig->render($response, 'sign-up.twig', [
                'errors' => $errors,
                'formData' => $formData
            ]);
        }

    }


    private function validateSignUpForm($formData): array
    {
        $errors = [];

        // Validate Email: It must be a valid email address (@salle.url.edu). The email must be unique among all users of the application.
        if (empty($formData['email']) || !filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'The email address is not valid';
        } elseif (!strpos($formData['email'], '@salle.url.edu')) {
            $errors['email'] = 'Only emails from the domain @salle.url.edu are accepted';
        } else {
            // Check if email is already registered (simulate database check)
            // Replace this with your actual database check
            $registeredEmail = "test@salle.url.edu"; // Example registered email
            if ($formData['email'] === $registeredEmail) {
                $errors['email'] = 'The email address is already registered';
            }
        }

        // Validate Password : Password: It must not be empty and must contain at least 7 characters, at least one number and both upper and lower case letters.
        if (empty($formData['password']) || strlen($formData['password']) < 7 || !preg_match('/[0-9]/', $formData['password']) || !preg_match('/[A-Z]/', $formData['password']) || !preg_match('/[a-z]/', $formData['password'])) {
            $errors['password'] = 'Password must be at least 7 characters long and contain at least one uppercase letter, one lowercase letter, and one number';
        }

        // Repeat password: It must be the same as the password field.
        if ($formData['password'] !== $formData['repeatPassword']) {
            $errors['repeatPassword'] = 'Passwords do not match';
        }

        // Validate optional field numBitcoins
        if (!empty($formData['numBitcoins'])) {
            if (!is_numeric($formData['numBitcoins']) || $formData['numBitcoins'] < 0 || $formData['numBitcoins'] > 40000) {
                $errors['numBitcoins'] = 'Sorry, the number of Bitcoins is either below or above the limits';
            }
        }

        return $errors;
    }
}