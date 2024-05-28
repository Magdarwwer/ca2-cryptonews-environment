<?php

namespace Salle\LSCryptoNews\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class NewsController
{
    private Twig $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function showNews(Request $request, Response $response): Response
    {
        // Check if the user is authenticated
        $authenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true;

        if (!$authenticated) {
            // If not authenticated, redirect to sign-in page
            return $this->twig->render($response, 'news.twig');
        }

        $articles = $this->fetchArticles();

        // Render the news page using Twig
        return $this->twig->render($response, 'news.twig', [
            'authenticated' => $authenticated,
            'articles' => $articles, // Pass fetched articles to the Twig template
        ]);
    }

    private function fetchArticles(): array
    {
        //
//        $apiUrl = 'https://api.example.com/articles';
//
//
//        $curl = curl_init();
//
//
//        curl_setopt_array($curl, [
//            CURLOPT_URL => $apiUrl,
//            CURLOPT_RETURNTRANSFER => true, // Return the response instead of outputting it
//            CURLOPT_TIMEOUT => 10, // Timeout in seconds
//        ]);
//
//        $response = curl_exec($curl);
//
//        if ($response === false) {
//            // Handle cURL error
//            $error = curl_error($curl);
//            throw new \Exception('Failed to fetch articles: ' . $error);
//        }
//

        return [
            [
                'title' => 'Article 1',
                'publication_date' => '2024-04-15',
                'author' => 'John Doe',
                'summary' => 'This is a summary of the first article.',
            ],
            [
                'title' => 'Article 2',
                'publication_date' => '2024-04-16',
                'author' => 'Jane Smith',
                'summary' => 'This is a summary of the second article.',
            ],
            [
                'title' => 'Article 3',
                'publication_date' => '2024-04-16',
                'author' => 'Jane Smith',
                'summary' => 'This is a summary of the second article.',
            ],
            [
                'title' => 'Article 4',
                'publication_date' => '2024-04-16',
                'author' => 'Jane Smith',
                'summary' => 'This is a summary of the second article.',
            ],

        ];

        //  return $articles;
    }
}