<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/bootstrap.php';

use Interceptor\{
    Route,
    Response
};

use App\Infrastructure\User\UserRepo;
use App\Application\User\UserLoginRequest;
use App\Application\User\UserRegisterRequest;
use App\Application\LogoutService;
use App\Application\Pass\PassUserRequest;
use App\Application\Like\LikeUserRequest;
use App\Application\Match\NewMatchRequest;
use App\Application\Message\SendMessageRequest;

use App\Domain\CreatedOn\CreatedOn;
use App\Domain\Action\Action;
use App\Domain\Action\ActionId\ActionId;
use App\Domain\Action\Type\Type;
use App\Domain\User\UserId\UserId;


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
        $user = $login_serv->execute(new UserLoginRequest(
            $request->retrive('email'),
            $request->retrive('password')
        ));
        Response::asJson($user);
    } catch(\Exception $e) {
        dd($e->getMessage());
    }
}));


// Route for User logout
$router->add(Route::get('logout', function() {
    try {
        LogoutService::execute();
        Response::asJson([ 'result' => 'User was logged out from the app' ]);
    } catch(\Exception $e) {
        dd($e->getMessage());
    }
}));


// Route for User register
$router->add(Route::post('register', function($request) use ($container) {
    $register_serv = $container->get(App\Application\User\UserRegisterService::class);
    try {
        $user = $register_serv->execute(new UserRegisterRequest(
            $request->dump()->name,
            $request->dump()->birth_date,
            $request->dump()->email,
            $request->dump()->password
        ));
        Response::asJson($user);
    } catch(\Exception $e) {
        dd($e->getMessage());
    }
}));


// Get all users
$router->add(Route::get('users', function($request) use ($container) {
    $get_users_serv = $container->get(App\Application\User\GetUsersService::class);
    $users = $get_users_serv->execute();
    Response::asJson($users);
}));


// Test the domain event store
$router->add(Route::get('test', function($request) use ($container, $publisher) {

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

    $mihai_id    = 'BEA33193-ABA1-4C81-A26C-0E6FBCA1B7A3';
    $cristina_id = 'F5027A89-3E1E-4828-B31C-E18D1020352F';

    try {
        $action = new Action(
            new ActionId('F5027A89-3E1E-4828-B31C-E18D1020352F'),
            Type::like(),
            new UserId($mihai_id),
            new UserId($cristina_id),
            new CreatedOn()
        );
        $action->setType( Type::pass(), new CreatedOn() );
        Response::asJson($action);
    } catch(\Exception $e) {
        dd($e->getMessage());
    }
    // try {
    //     $created_on = new CreatedOn('1989-11-07 7:20');
    //     dd($created_on->getDate());
    // } catch(\Exception $e) {
    //     dd($e->getMessage());
    // }
}));


$router->add(Route::post('like', function($request) use ($container) {
    $like_user_srv = $container->get(App\Application\Like\LikeUserService::class);
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
    $pass_user_srv = $container->get(App\Application\Pass\PassUserService::class);
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
    $send_message_srv = $container->get(App\Application\Message\SendMessageService::class);

    try {
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
    $create_match_serv = $container->get(App\Application\Match\CreateNewMatchService::class);
    try {
        $match = $create_match_serv->execute(new NewMatchRequest(
            $request->dump()->like_a,
            $request->dump()->like_b
        ));
        Response::asJson($match);
    } catch(\Exception $e) {
        dd($e->getMessage());
    }
}));


// Run the Router
try {
    $router->run();
} catch(Exception $e) {
    return var_dump(404);
}
