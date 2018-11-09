<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap.php';

use Interceptor\Route;
use App\Domain\User\{
    UserFactory,
    LoginService,
    Email\Email,
    Password\password
};
use App\Infrastructure\User\UserRepo;


$router  = $container->get(Interceptor\Router::class);
$request = $container->get(Interceptor\Request::class);

$router->add(new Route('login', function() use ($request, $container) {
    $user_repo = $container->get(App\Infrastructure\User\UserRepo::class);
    $login_serv = new LoginService($user_repo);

    $email    = new Email($request->retrive('email'));
    $password = new Password($request->retrive('password'));

    $logged_user = $login_serv->execute($email, $password);
    var_dump($logged_user);
}));

$router->add(new Route('register', function() use ($container) {
    $user_repo = $container->get(App\Infrastructure\User\UserRepo::class);
    $user = UserFactory::build(
        $user_repo->nextId(),
        'Mihai Blebea',
        '07/11/1989',
        'mihaiserban.blebea@gmail.com',
        'intrex');

    $user_repo->add($user);
    var_dump($user);
}));

try {
    $router->run();
} catch(Exception $e) {
    return var_dump(404);
}
