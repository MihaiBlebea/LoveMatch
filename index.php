<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/bootstrap.php';


use Firebase\JWT\JWT;
use Interceptor\Route;
use Interceptor\Response;
use Interceptor\Middleware;


// use App\Application\Match\CreateMatch\CreateMatchRequest;
// use App\Application\Match\GetMatches\GetMatchesRequest;
// use App\Application\Message\SendMessageRequest;
// use App\Application\Action\CreateActionRequest;
// use App\Application\User\UserLogin\ValidateTokenRequest;
// use App\Application\User\GetUsers\GetUsersRequest;
// use App\Application\User\AttachImage\AttachImageRequest;
// use App\Application\User\AttachDescription\AttachDescriptionRequest;
// use App\Application\User\GetMe\GetMeRequest;


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


$router->injectInController($container);


// Middleware that will check the header for JWT auth
$auth = Middleware::apply(function($request, $next) use ($container) {
    if(!$request->retrive('auth_token'))
    {
        dd('Token not given');
    }
    $validate_token_serv = $container->get('ValidateUserTokenService');
    $user = $validate_token_serv->execute(new ValidateTokenRequest($request->retrive('auth_token')));
    if($user !== null)
    {
        return $next;
    }
    dd('Token expired');
});


$router->add(Route::post('login', 'Controllers\AuthController@login'));

$router->add(Route::post('register', 'Controllers\AuthController@register'));


$router->add(Route::get('users', 'Controllers\UserController@getUsers'));

$router->add(Route::get('user', 'Controllers\UserController@getUser'));

$router->add(Route::post('test', 'Controllers\UserController@updateUser'));


$router->add(Route::post('image', function($request) use ($container) {
    $attach_img_serv = $container->get('AttachImageService');
    try {
        $user = $attach_img_serv->execute(new AttachImageRequest(
            $request->retrive('user_id'),
            $request->retrive('image_path')
        ));
        Response::asJson($user);
    } catch(\Exception $e) {
        Response::asJson([ 'error' => $e->getMessage() ]);
    }
}));


$router->add(Route::post('description', function($request) use ($container) {
    $attach_description_serv = $container->get('AttachDescriptionService');
    try {
        $user = $attach_description_serv->execute(new AttachDescriptionRequest(
            $request->retrive('description'),
            $request->retrive('user_id')
        ));
        Response::asJson($user);
    } catch(\Exception $e) {
        Response::asJson([ 'error' => $e->getMEssage() ]);
    }
}));


$router->add(Route::post('action', 'Controllers\ActionController@createAction'));


// $router->add(Route::post('match', function($request) use ($container) {
//     $create_match_serv = $container->get('CreateMatchService');
//     try {
//         $match = $create_match_serv->execute(new CreateMatchRequest(
//             $request->retrive('first_user_id'),
//             $request->retrive('second_user_id')
//         ));
//         Response::asJson($match);
//     } catch(\Exception $e) {
//         Response::asJson([ 'error' => $e->getMessage() ]);
//     }
// }));

$router->add(Route::post('match', 'Controllers\MatchController@createMatch'));

$router->add(Route::get('matches', 'Controllers\MatchController@getUserMatches'));


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
    dd($e->getMessage());
    return 404;
}
