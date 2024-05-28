<?php

namespace Salle\LSCryptoNews\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Salle\LSCryptoNews\model\UserRepository;

class MarketController
{
    private Twig $twig;
    private UserRepository $userRepository;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function showMarket(Request $request, Response $response): Response
    {
        // Render sign-up form using Twig
        //return $this->twig->render($response, 'mkt.twig');

        // Check if the user is authenticated
        $authenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true;

        // If not authenticated, display a welcome message
        if (!$authenticated) {
            return $this->twig->render($response, 'mkt.twig', [
                'authenticated' => false,
                'message' => 'Welcome to CryptoNews! Login if you want to see your updated data.',
            ]);
        }

        $userId = $_SESSION['user_id'];
        $cryptoBalance = $this->userRepository->getCryptoBalance($userId);

        $marketData = $this->fetchMarketData();

        // Render the market updates page using Twig
        return $this->twig->render($response, 'mkt.twig', [
            'authenticated' => true,
            'cryptoBalance' => $cryptoBalance,
            'marketData' => $marketData,
        ]);
    }

    private function fetchMarketData(): array
    {
        return [
            [
                'name' => 'Bitcoin',
                'price' => 50000,
            ],
            [
                'name' => 'Etherium',
                'price' => 30000,
            ],
            [
                'name' => 'Idena',
                'price' => 15000,
            ],
        ];
    }
}