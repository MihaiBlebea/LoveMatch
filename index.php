<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/bootstrap.php';

use Interceptor\{
    Route,
    Response
};

use App\Application\User\UserLogin\UserLoginRequest;
use App\Application\User\UserRegister\UserRegisterRequest;

use App\Application\LogoutService;
use App\Application\Match\CreateMatch\CreateMatchRequest;
use App\Application\Match\GetMatches\GetMatchesRequest;
use App\Application\Message\SendMessageRequest;
use App\Application\Action\CreateActionRequest;


// Init DomainEventPublisher
// Get the publisher instance
$publisher = App\Domain\DomainEventPublisher::instance();

// Get the persist event listener
$persist_listener = $container->get(App\Domain\PersistDomainEventSubscriber::class);

// Subscribe the listener to the publisher
$publisher->subscribe($persist_listener);

// Get Router components
$router  = $container->get(Interceptor\Router::class);
$request = $container->get(Interceptor\Request::class);


// Route for User login
$router->add(new Route('login', function() use ($request, $container) {
    $login_serv = $container->get(App\Application\User\UserLogin\UserLoginService::class);
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
    $register_serv = $container->get(App\Application\User\UserRegister\UserRegisterService::class);
    try {
        $user = $register_serv->execute(new UserRegisterRequest(
            $request->dump()->name,
            $request->dump()->birth_date,
            $request->dump()->gender,
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
    $get_users_serv = $container->get(App\Application\User\GetUsers\GetUsersService::class);
    $users = $get_users_serv->execute();
    Response::asJson($users);
}));


$router->add(Route::post('action', function($request) use ($container) {
    $create_action_serv = $container->get(App\Application\Action\CreateActionService::class);
    try {
        $action = $create_action_serv->execute(new CreateActionRequest(
            $request->dump()->type,
            $request->dump()->sender_id,
            $request->dump()->receiver_id
        ));
        Response::asJson($action);
    } catch(\Exception $e) {
        dd($e->getMessage());
    }
}));


$router->add(Route::post('match', function($request) use ($container) {
    $create_match_serv = $container->get(App\Application\Match\CreateMatch\CreateMatchService::class);
    try {
        $match = $create_match_serv->execute(new CreateMatchRequest(
            $request->dump()->first_user_id,
            $request->dump()->second_user_id
        ));
        Response::asJson($match);
    } catch(\Exception $e) {
        dd($e->getMessage());
    }
}));


$router->add(Route::get('matches', function($request) use ($container) {
    $get_match_serv = $container->get(App\Application\Match\GetMatches\GetMatchesService::class);
    try {
        $matches = $get_match_serv->execute(new GetMatchesRequest($request->retrive('user_id')));
        Response::asJson($matches);
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





// Run the Router
try {
    $router->run();
} catch(Exception $e) {
    return var_dump(404);
}
