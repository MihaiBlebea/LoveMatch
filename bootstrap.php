<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once __DIR__ . '/vendor/autoload.php';


use League\Container\Container;



// Create the container
$container = new Container();

// Add dependencies in the container
$container->add(Interceptor\Request::class);

$container->add(Interceptor\Router::class)
          ->addArgument(Interceptor\Request::class);

$container->add(Domino\Connector::class)
          ->addArgument('mysql')
          ->addArgument('love_match')
          ->addArgument('root')
          ->addArgument('root');

$container->add(Domino\Persistence::class)
          ->addArgument(Domino\Connector::class);

$container->add(App\Infrastructure\User\UserRepo::class)
          ->addArgument(Domino\Persistence::class);

$container->add(App\Infrastructure\Pass\PassRepo::class)
          ->addArgument(Domino\Persistence::class);

$container->add(App\Infrastructure\Like\LikeRepo::class)
          ->addArgument(Domino\Persistence::class);

$container->add(App\Infrastructure\Message\MessageRepo::class)
          ->addArgument(Domino\Persistence::class);

$container->add(App\Infrastructure\Match\MatchRepo::class)
          ->addArgument(Domino\Persistence::class);

$container->add(App\Infrastructure\Event\EventStore::class)
          ->addArgument(Domino\Persistence::class);

$container->add(App\Domain\PersistDomainEventSubscriber::class)
          ->addArgument(App\Infrastructure\Event\EventStore::class);


$container->add(App\Domain\User\UserLoginService::class)
          ->addArgument(App\Infrastructure\User\UserRepo::class);

$container->add(App\Domain\User\UserRegisterService::class)
          ->addArgument(App\Infrastructure\User\UserRepo::class);

$container->add(App\Domain\Pass\PassUserService::class)
          ->addArgument(App\Infrastructure\User\UserRepo::class)
          ->addArgument(App\Infrastructure\Pass\PassRepo::class);

$container->add(App\Domain\Like\LikeUserService::class)
          ->addArgument(App\Infrastructure\User\UserRepo::class)
          ->addArgument(App\Infrastructure\Like\LikeRepo::class);
