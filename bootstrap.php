<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once __DIR__ . '/vendor/autoload.php';


use League\Container\Container;
use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;


// Bootstrap Whoops debug
$whoops = new Run();
$whoops->pushHandler(new PrettyPageHandler());
$whoops->register();


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


$container->add('UserRepo', App\Infrastructure\Persistence\User\DominoUserRepo::class)
          ->addArgument(Domino\Persistence::class);


$container->add('ActionRepo', App\Infrastructure\Persistence\Action\DominoActionRepo::class)
          ->addArgument(Domino\Persistence::class);


$container->add('MessageRepo', App\Infrastructure\Persistence\Message\DominoMessageRepo::class)
          ->addArgument(Domino\Persistence::class);


$container->add('MatchRepo', App\Infrastructure\Persistence\Match\DominoMatchRepo::class)
          ->addArgument(Domino\Persistence::class);


$container->add('EventStore', App\Infrastructure\Event\EventStore::class)
          ->addArgument(Domino\Persistence::class);


$container->add('PersistDomainEventSubscriber', App\Domain\PersistDomainEventSubscriber::class)
          ->addArgument('EventStore');


$container->add('UserLoginService', App\Application\User\UserLogin\UserLoginService::class)
          ->addArgument('UserRepo');


$container->add('ValidateUserTokenService', App\Application\User\UserLogin\ValidateUserTokenService::class)
          ->addArgument('UserRepo');


$container->add('UserRegisterService', App\Application\User\UserRegister\UserRegisterService::class)
          ->addArgument('UserRepo');


$container->add('CreateActionService', App\Application\Action\CreateActionService::class)
          ->addArgument('ActionRepo')
          ->addArgument('UserRepo');


$container->add('SendMessageService', App\Application\Message\SendMessageService::class)
          ->addArgument('MessageRepo')
          ->addArgument('UserRepo')
          ->addArgument('MatchRepo');


$container->add('CreateMatchService', App\Application\Match\CreateMatch\CreateMatchService::class)
          ->addArgument('MatchRepo')
          ->addArgument('UserRepo');


$container->add('GetUsersService', App\Application\User\GetUsers\GetUsersService::class)
          ->addArgument('UserRepo');


$container->add('GetMatchesService', App\Application\Match\GetMatches\GetMatchesService::class)
          ->addArgument('MatchRepo');
