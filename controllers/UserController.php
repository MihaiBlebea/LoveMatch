<?php

namespace Controllers;

use Interceptor\Interfaces\RequestInterface;
use Interceptor\Response;
use League\Container\Container;

use App\Application\User\GetUsers\GetUsersRequest;
use App\Application\User\GetMe\GetMeRequest;
use App\Application\User\UpdateUser\UpdateUserRequest;
use App\Application\User\AttachDescription\AttachDescriptionRequest;
use App\Application\User\AttachImage\AttachImageRequest;



class UserController
{
    public function getUser(RequestInterface $request, Container $container)
    {
        $get_me_serv = $container->get('GetMeService');
        try {
            $user = $get_me_serv->execute(new GetMeRequest($request->retrive('user_id')));
            Response::asJson($user);
        } catch (\Exception $e) {
            Response::asJson([ 'error' => $e->getMessage() ]);
        }
    }

    public function updateUser(RequestInterface $request, Container $container)
    {
        $update_user_serv = $container->get('UpdateUserService');
        $attach_desc_serv = $container->get('AttachDescriptionService');
        $attach_img_serv  = $container->get('AttachImageService');
        try {
            $user = $update_user_serv->execute(new UpdateUserRequest(
                $request->retrive('id'),
                $request->retrive('name'),
                $request->retrive('birth_date'),
                $request->retrive('gender'),
                $request->retrive('email'),
                $request->retrive('latitude'),
                $request->retrive('longitude')
            ));

            if($request->retrive('description'))
            {
                $user = $attach_desc_serv->execute(new AttachDescriptionRequest(
                    $request->retrive('description'),
                    $request->retrive('id')
                ));
            }

            $user = $attach_img_serv->execute(new AttachImageRequest(
                $request->retrive('id'),
                $request->retrive('images')
            ));

            Response::asJson($user);
        } catch (\Exception $e) {
            Response::asJson([ 'error' => $e->getMessage() ]);
        }
    }

    public function getUsers(RequestInterface $request, Container $container)
    {
        $get_users_serv = $container->get('GetUsersService');
        try {
            $users = $get_users_serv->execute(new GetUsersRequest(
                $request->retrive('count'),
                $request->retrive('user_id')
            ));
            if($users === null)
            {
                $users = [];
            }
            Response::asJson($users);
        } catch(\Exception $e) {
            Response::asJson([ 'error' => $e->getMessage() ]);
        }
    }
}
