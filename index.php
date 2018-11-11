<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/bootstrap.php';

use Interceptor\Route;
use App\Domain\User\{
    UserFactory,
    UserLoginService,
    UserLogoutService,
    Email\Email
};
use App\Infrastructure\User\UserRepo;
use App\Application\UserLoginRequest;
use App\Domain\Pass\{
    PassId\PassId,
    Pass
};
use App\Domain\Message\Message;


$router  = $container->get(Interceptor\Router::class);
$request = $container->get(Interceptor\Request::class);


// Route for User login
$router->add(new Route('login', function() use ($request, $container) {
    $user_repo = $container->get(App\Infrastructure\User\UserRepo::class);
    $login_serv = new UserLoginService($user_repo);

    $email    = $request->retrive('email');
    $password = $request->retrive('password');

    try {
        $logged_user = $login_serv->execute(new UserLoginRequest($email, $password));
        var_dump($logged_user);
    } catch(\Exception $e) {
        var_dump($e->getMessage());
    }
}));


// Route for User logout
$router->add(Route::get('logout', function() {
    UserLogoutService::execute();
    var_dump('User was logged out from the app');
}));


// Route for User register
$router->add(new Route('register', function() use ($container) {
    $user_repo = $container->get(App\Infrastructure\User\UserRepo::class);
    $user = UserFactory::build(
        $user_repo->nextId(),
        'Mihai Blebea',
        '1989-11-07',
        'mihaiserban.blebea@gmail.com',
        'intrex');

    $user_repo->add($user);
    $saved_user = $user_repo->withEmail(new Email('mihaiserban.blebea@gmail.com'));
    var_dump($saved_user);
}));


// Test the domain event store
$router->add(Route::get('test', function() use ($container, $publisher) {

    // Get a random user from database
    $user_repo = $container->get(App\Infrastructure\User\UserRepo::class);
    $user = $user_repo->withEmail(new Email('mihaiserban.blebea@gmail.com'));

    // Get the the subscriber from the container, it can be any subscriber / listener
    $persist_listener = $container->get(App\Infrastructure\Event\PersistDomainEventSubscriber::class);

    // Subscribe the listener to the publisher
    $publisher->subscribe($persist_listener);

    // Publish the event
    $publisher->publish(new App\Domain\User\UserLoggedIn($user->getId()));

    var_dump($publisher);
}));


$router->add(Route::get('like', function() {
    var_dump('like');
}));


$router->add(Route::get('pass', function() use ($container) {
    $user_repo = $container->get(App\Infrastructure\User\UserRepo::class);
    $mihai = UserFactory::build(
        $user_repo->nextId(),
        'Mihai Blebea',
        '1989-11-07',
        'mihaiserban.blebea@gmail.com',
        'intrex');
    $user_repo->add($mihai);

    $cristina = UserFactory::build(
        $user_repo->nextId(),
        'Cristina Aliman',
        '1986-04-11',
        'cristinaliman@gmail.com',
        'intrex');
    $user_repo->add($cristina);

    $pass_repo = $container->get(App\Infrastructure\Pass\PassRepo::class);
    $pass = new Pass(
        $pass_repo->nextId(),
        $mihai,
        $cristina);
    $pass_repo->add($pass);

    $saved_pass = $pass_repo->withId($pass->getId());
    dd($saved_pass);
}));


$router->add(Route::get('message', function() {
    
}));

// Run the Router
try {
    $router->run();
} catch(Exception $e) {
    return var_dump(404);
}
