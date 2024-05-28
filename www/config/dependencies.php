<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DI\Container;
use DI\ContainerBuilder;
use Psr\Http\Message\ResponseFactoryInterface;
use Salle\LSCryptoNews\model\repository\MySqlUserRepository;
use Psr\Container\ContainerInterface;
use Salle\LSCryptoNews\model\UserRepository;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Views\Twig;
use Slim\Flash\Messages;
use Salle\LSCryptoNews\model\repository\PDOSingleton;

$containerBuilder = new ContainerBuilder();
$container = $containerBuilder->build();

$container->set(ResponseFactoryInterface::class, function () {
    return new ResponseFactory();
});

$container->set('view', function (Container $container) {
    return Twig::create(__DIR__ . '/../templates', ['cache' => false]);
});
$container->set(Twig::class, function (Container $container) {
    return $container->get('view');
});

$container->set(Messages::class, function (Container $container) {
    return new Messages();
});

$container->set('db_config', [
    'username' => $_ENV['MYSQL_USER'] ?? '',
    'password' => $_ENV['MYSQL_PASSWORD'] ?? '',
    'host' => $_ENV['MYSQL_HOST'] ?? '',
    'port' => $_ENV['MYSQL_PORT'] ?? '',
    'databse' => $_ENV['MYSQL_DATABASE'] ?? ''
]);

$container->set('db', function (ContainerInterface $c) {
    $config = $c->get('db_config');
    return PDOSingleton::getInstance(
        $config['username'],
        $config['password'],
        $config['host'],
        $config['port'],
        $config['database']
    );
});

$container->set(UserRepository::class, function (ContainerInterface $c) {
    $database = $c->get('db');
    return $c->get(MySqlUserRepository::class);
});