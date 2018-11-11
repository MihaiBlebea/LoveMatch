<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once __DIR__ . '/vendor/autoload.php';


use League\Container\Container;
use App\Infrastructure\Event\DomainEventPublisher;


// Create the instance of DomainEventPublisher
$publisher = DomainEventPublisher::instance();


// Create the container
$container = new Container();

// Add dependencies in the container
$container->add(Interceptor\Request::class);

$container->add(Interceptor\Router::class)->addArgument(Interceptor\Request::class);

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

$container->add(App\Infrastructure\Event\EventStore::class)
          ->addArgument(Domino\Persistence::class);

$container->add(App\Infrastructure\Event\PersistDomainEventSubscriber::class)
          ->addArgument(App\Infrastructure\Event\EventStore::class);
