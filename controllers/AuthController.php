<?php

namespace Controllers;

use Interceptor\Interfaces\RequestInterface;
use Interceptor\Response;
use League\Container\Container;

use App\Application\User\UserLogin\UserLoginRequest;
use App\Application\User\UserRegister\UserRegisterRequest;



class AuthController
{
    public function register(RequestInterface $request, Container $container)
    {
        $register_serv = $container->get('UserRegisterService');
        try {
            $user = $register_serv->execute(new UserRegisterRequest(
                $request->retrive('name'),
                $request->retrive('birth_date'),
                $request->retrive('gender'),
                $request->retrive('email'),
                $request->retrive('longitude'),
                $request->retrive('latitude'),
                $request->retrive('password')
            ));
            Response::asJson($user);
        } catch(\Exception $e) {
            Response::asJson([ 'error' => $e->getMessage() ]);
        }
    }

    public function login(RequestInterface $request, Container $container)
    {
        $login_serv = $container->get('UserLoginService');
        try {
            $user = $login_serv->execute(new UserLoginRequest(
                $request->retrive('email'),
                $request->retrive('password')
            ));
            if($user)
            {
                Response::asJson([
                    'token'   => (string) $user->getToken(),
                    'user_id' => (string) $user->getId()
                ]);
            }
        } catch(\Exception $e) {
            Response::asJson([ 'error' => $e->getMessage() ]);
        }
    }

}
