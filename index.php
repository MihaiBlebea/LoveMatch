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
use App\Application\Match\NewMatchRequest;
use App\Application\Message\SendMessageRequest;
use App\Application\Action\CreateActionRequest;

// Dependencies for testing the User Aggregate
use App\Domain\User\User;
use App\Domain\User\UserId\UserId;
use App\Domain\User\Name\Name;
use App\Domain\User\BirthDate\BirthDate;
use App\Domain\User\Gender\Gender;
use App\Domain\User\Email\Email;
use App\Domain\User\Password\Password;
use App\Domain\CreatedOn\CreatedOn;
use App\Domain\User\Action\Action;
use App\Domain\User\Action\ActionId\ActionId;
use App\Domain\User\Action\Type\Type;


// Dependencies for testing Match Aggregate
use App\Domain\Match\Match;
use App\Domain\Match\Message\Message;
use App\Domain\Match\Message\Body\Body;


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
$router->add(Route::get('test', function($request) use ($container) {
    $user_repo    = $container->get(App\Infrastructure\User\UserRepo::class);
    $action_repo  = $container->get(App\Infrastructure\Action\ActionRepo::class);
    $match_repo   = $container->get(App\Infrastructure\Match\MatchRepo::class);
    $message_repo = $container->get(App\Infrastructure\Message\MessageRepo::class);

    $mihai = new User(
        $user_repo->nextId(),
        new Name('Mihai Blebea'),
        new BirthDate('1989-11-07'),
        new Gender('male'),
        new Email('serbantrnor@gmail.com'),
        new Password('intrex'),
        new CreatedOn()
    );

    $cristina = new User(
        $user_repo->nextId(),
        new Name('Cristina Aliman'),
        new BirthDate('1986-04-11'),
        new Gender('female'),
        new Email('cristinaliman@gmail.com'),
        new Password('intrex'),
        new CreatedOn()
    );

    $like = new Action(
        $action_repo->nextId(),
        new Type('like'),
        $mihai->getId(),
        $cristina->getId(),
        new CreatedOn()
    );

    $pass = new Action(
        $action_repo->nextId(),
        new Type('pass'),
        $mihai->getId(),
        $cristina->getId(),
        new CreatedOn()
    );

    $mihai->addActions([$like, $pass]);


    $match = new Match(
        $match_repo->nextId(),
        $mihai,
        $cristina,
        new CreatedOn()
    );

    // $message = new Message(
    //     $message_repo->nextId(),
    //     $mihai,
    //     $cristina,
    //     new Body('Ce faci Cristina? Esti bine?'),
    //     new CreatedOn()
    // );

    $match->addMessage([
        'id'       => $message_repo->nextId(),
        'sender'   => $mihai,
        'receiver' => $cristina,
        'body'     => new Body('Ce faci Cristina? Esti bine?')
    ]);

    // Try and save User aggregate
    // try {
    //     $user_repo->add($mihai);
    // } catch(\Exception $e) {
    //     dd($e->getMessage());
    // }

    // Try and save Match aggregate
    try {
        $match_repo->add($match);
    } catch(\Exception $e) {
        dd($e->getMessage());
    }

    // dd($match);
    dd($mihai, $cristina);

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
