<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/bootstrap.php';

use Interceptor\{
    Route,
    Response
};
// use App\Domain\User\{
//     UserFactory,
//     UserLoginService,
//     Email\Email,
//     UserId\UserId
// };
use App\Infrastructure\User\UserRepo;
use App\Application\User\UserLoginRequest;
use App\Application\User\UserRegisterRequest;
use App\Application\LogoutService;
use App\Application\Pass\PassUserRequest;
use App\Application\Like\LikeUserRequest;
use App\Domain\Pass\PassUserService;

use App\Application\Message\SendMessageRequest;
use App\Domain\Message\SendMessageService;

use App\Domain\Like\LikeId\LikeId;
use App\Domain\Match\Match;
use App\Domain\MAtch\MatchId\MatchId;


// Init DomainEventPublisher
// Get the publisher instance
$publisher = App\Domain\DomainEventPublisher::instance();

// Get the persist event listener
$persist_listener = $container->get(App\Domain\PersistDomainEventSubscriber::class);

// Subscribe the listener to the publisher
$publisher->subscribe($persist_listener);



$router  = $container->get(Interceptor\Router::class);
$request = $container->get(Interceptor\Request::class);


// Route for User login
$router->add(new Route('login', function() use ($request, $container) {
    $login_serv = $container->get(App\Domain\User\UserLoginService::class);

    try {
        $logged_user = $login_serv->execute(new UserLoginRequest(
            $request->retrive('email'),
            $request->retrive('password')
        ));
        Response::asJson($logged_user);
    } catch(\Exception $e) {
        var_dump($e->getMessage());
    }
}));


// Route for User logout
$router->add(Route::get('logout', function() {
    try {
        LogoutService::execute();
        dd('User was logged out from the app');
    } catch(\Exception $e) {
        dd($e->getMessage());
    }
}));


// Route for User register
$router->add(Route::post('register', function($request) use ($container) {
    $register_serv = $container->get(App\Domain\User\UserRegisterService::class);
    try {
        $register_serv->execute(new UserRegisterRequest(
            $request->dump()->name,
            $request->dump()->birth_date,
            $request->dump()->email,
            $request->dump()->password
        ));
        Response::asJson([ 'result' => 'Job done' ]);
    } catch(\Exception $e) {
        dd($e->getMessage());
    }
}));


// Test the domain event store
$router->add(Route::get('test', function() use ($container, $publisher) {

    // // Get a random user from database
    // $user_repo = $container->get(App\Infrastructure\User\UserRepo::class);
    // $user = $user_repo->withEmail(new Email('mihaiserban.blebea@gmail.com'));
    //
    // // Get the the subscriber from the container, it can be any subscriber / listener
    // $persist_listener = $container->get(App\Infrastructure\Event\PersistDomainEventSubscriber::class);
    //
    // // Subscribe the listener to the publisher
    // $publisher->subscribe($persist_listener);
    //
    // // Publish the event
    // $publisher->publish(new App\Domain\User\UserLoggedIn($user->getId()));
    //
    // var_dump($publisher);
    //
    // $publisher->publish(new App\Domain\User\UserLoggedIn(new UserId('7FC8643F-BEF8-4D78-BF9E-9FB89F124F12')));
    // dd($publisher);

    // $user_repo = $container->get(App\Infrastructure\User\UserRepo::class);
    // $mihai = UserFactory::build(
    //     $user_repo->nextId(),
    //     'Mihai Blebea',
    //     '1989-11-07',
    //     'mihaiserban.blebea@gmail.com',
    //     'intrex');
    //
    // Response::asJson($mihai);
}));


$router->add(Route::post('like', function($request) use ($container) {
    $like_user_srv = $container->get(App\Domain\Like\LikeUserService::class);
    try {
        $like_user_srv->execute(new LikeUserRequest(
            $request->dump()->owner,
            $request->dump()->receiver
        ));
    } catch(\Exception $e) {
        dd($e->getMessage());
    }
}));


$router->add(Route::post('pass', function($request) use ($container) {
    $pass_user_srv = $container->get(App\Domain\Pass\PassUserService::class);
    try {
        $pass_user_srv->execute(new PassUserRequest(
            $request->dump()->owner,
            $request->dump()->receiver
        ));
    } catch(\Exception $e) {
        dd($e->getMessage());
    }
}));


$router->add(Route::post('message', function($request) use ($container) {
    $user_repo    = $container->get(App\Infrastructure\User\UserRepo::class);
    $match_repo   = $container->get(App\Infrastructure\Match\MatchRepo::class);
    $message_repo = $container->get(App\Infrastructure\Message\MessageRepo::class);

    try {
        $send_message_srv = new SendMessageService($message_repo, $user_repo, $match_repo);
        $send_message_srv->execute(new SendMessageRequest(
            $request->dump()->sender_id,
            $request->dump()->receiver_id,
            $request->dump()->match_id,
            $request->dump()->body
        ));
        Response::asJson([ 'result' => 'Message was sent' ]);
    } catch(\Exception $e) {
        dd($e->getMessage());
    }
}));


$router->add(Route::post('match', function($request) use ($container) {
    $like_repo  = $container->get(App\Infrastructure\Like\LikeRepo::class);
    $match_repo = $container->get(App\Infrastructure\Match\MatchRepo::class);

    $like_a = $like_repo->withId(new LikeId($request->dump()->like_a));
    $like_b = $like_repo->withId(new LikeId($request->dump()->like_b));

    $match = new Match(
        $match_repo->nextId(),
        $like_a,
        $like_b);

    $match_repo->add($match);
    dd($match);
}));


// Run the Router
try {
    $router->run();
} catch(Exception $e) {
    return var_dump(404);
}
