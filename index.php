<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/bootstrap.php';


use Firebase\JWT\JWT;
use Interceptor\Route;
use Interceptor\Response;
use Interceptor\Middleware;

use App\Application\User\UserLogin\UserLoginRequest;
use App\Application\User\UserRegister\UserRegisterRequest;

use App\Application\LogoutService;
use App\Application\Match\CreateMatch\CreateMatchRequest;
use App\Application\Match\GetMatches\GetMatchesRequest;
use App\Application\Message\SendMessageRequest;
use App\Application\Action\CreateActionRequest;
use App\Application\User\UserLogin\ValidateTokenRequest;


// Init DomainEventPublisher
// Get the publisher instance
$publisher = App\Domain\DomainEventPublisher::instance();

// Get the persist event listener
$persist_listener = $container->get('PersistDomainEventSubscriber');

// Subscribe the listener to the publisher
$publisher->subscribe($persist_listener);

// Get Router components
$router  = $container->get(Interceptor\Router::class);
$request = $container->get(Interceptor\Request::class);


// Middleware that will check the header for JWT auth
$auth = Middleware::apply(function($request, $next) use ($container) {
    $validate_token_serv = $container->get('ValidateUserTokenService');
    $user = $validate_token_serv->execute(new ValidateTokenRequest($_SERVER['HTTP_JWT']));

    if($user !== null)
    {
        return $next;
    }
});


// Route for User login
$router->add(Route::get('login', function() use ($request, $container) {
    $login_serv = $container->get('UserLoginService');
    try {
        $user = $login_serv->execute(new UserLoginRequest(
            $request->retrive('email'),
            $request->retrive('password')
        ));
        if($user)
        {
            Response::asJson([ 'token' => (string) $user->getToken() ]);
        }

    } catch(\Exception $e) {
        Response::asJson([ 'error' => $e->getMessage() ]);
    }
}));


// Route for User logout
$router->add(Route::get('logout', function() {
    try {
        LogoutService::execute();
        Response::asJson([ 'result' => 'User was logged out from the app' ]);
    } catch(\Exception $e) {
        Response::asJson([ 'error' => $e->getMessage() ]);
    }
}));


// Route for User register
$router->add(Route::post('register', function($request) use ($container) {
    $register_serv = $container->get('UserRegisterService');
    try {
        $user = $register_serv->execute(new UserRegisterRequest(
            $request->retrive('name'),
            $request->retrive('birth_date'),
            $request->retrive('gender'),
            $request->retrive('email'),
            $request->retrive('password')
        ));
        Response::asJson($user);
    } catch(\Exception $e) {
        Response::asJson([ 'error' => $e->getMessage() ]);
    }
}));


// Get all users with JWT auth middleware
$router->add(Route::get('users', function($request) use ($container) {
    $get_users_serv = $container->get('GetUsersService');
    try {
        $users = $get_users_serv->execute();
        Response::asJson($users);
    } catch(\Exception $e) {
        Response::asJson([ 'error' => $e->getMessage() ]);
    }
}, $auth));


$router->add(Route::post('action', function($request) use ($container) {
    $create_action_serv = $container->get('CreateActionService');
    try {
        $action = $create_action_serv->execute(new CreateActionRequest(
            $request->retrive('type'),
            $request->retrive('sender_id'),
            $request->retrive('retrive_id')
        ));
        Response::asJson($action);
    } catch(\Exception $e) {
        Response::asJson([ 'error' => $e->getMessage() ]);
    }
}));


$router->add(Route::post('match', function($request) use ($container) {
    $create_match_serv = $container->get('CreateMatchService');
    try {
        $match = $create_match_serv->execute(new CreateMatchRequest(
            $request->retrive('first_user_id'),
            $request->retrive('second_user_id')
        ));
        Response::asJson($match);
    } catch(\Exception $e) {
        Response::asJson([ 'error' => $e->getMessage() ]);
    }
}));


$router->add(Route::get('matches', function($request) use ($container) {
    $get_match_serv = $container->get('GetMatchesService');
    try {
        $matches = $get_match_serv->execute(new GetMatchesRequest($request->retrive('user_id')));
        Response::asJson($matches);
    } catch(\Exception $e) {
        Response::asJson([ 'error' => $e->getMessage() ]);
    }
}));


$router->add(Route::post('message', function($request) use ($container) {
    $send_message_srv = $container->get('SendMessageService');

    try {
        $send_message_srv->execute(new SendMessageRequest(
            $request->retrive('sender_id'),
            $request->retrive('receiver_id'),
            $request->retrive('match_id'),
            $request->retrive('body')
        ));
        Response::asJson([ 'result' => 'Message was sent' ]);
    } catch(\Exception $e) {
        Response::asJson([ 'error' => $e->getMessage() ]);
    }
}));


// Run the Router
try {
    $router->run();
} catch(Exception $e) {
    return 404;
}
