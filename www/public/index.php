<?php
declare(strict_types=1);<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Salle\LSCryptoNews\Controller\SignUpController;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;


require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->addErrorMiddleware(true, true, false);


$app->get('/hello/{name}', function (Request $request, Response $response, $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});

$containerBuilder = new ContainerBuilder();
$container = $containerBuilder->build();

$container->set('view', function () {
    return Twig::create('templates');
});

$app = AppFactory::createFromContainer($container);

$app->add(TwigMiddleware::createFromContainer($app));

$app->get('/index', function ($request, $response) {
    return $this->get('view')->render($response, 'index.twig', ['name' => 'World']);
});

$app->get('/sign-up', function ($request, $response) {
    return $this->get('view')->render($response, 'sign-up.twig');
});

$app->post('/sign-up', function (Request $request, Response $response) use ($container) {
    $signupController = $container->get(SignUpController::class);
    return $signupController->apply($request, $response);
});

$app->get('/sign-in', function (Request $request, Response $response) {
    return $this->get('view')->render($response, 'sign-in.twig');
});

$app->post('/sign-in', function (Request $request, Response $response) {
    return $response->withHeader('Location', '/')->withStatus(302);
});

$app->get('/', function ($request, $response) {
    return $this->get('view')->render($response, 'home.twig');
});

$app->get('/news', function ($request, $response) {
    return $this->get('view')->render($response, 'news.twig');
});

$app->get('/mkt', function ($request, $response) {
    return $this->get('view')->render($response, 'mkt.twig');
});

$app->run();