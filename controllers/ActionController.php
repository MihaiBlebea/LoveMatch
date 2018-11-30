<?php

namespace Controllers;

use Interceptor\Interfaces\RequestInterface;
use Interceptor\Response;
use League\Container\Container;

use App\Application\Action\CreateActionRequest;
use App\Application\Match\CreateMatch\CreateMatchRequest;



class ActionController
{
    public function createAction(RequestInterface $request, Container $container)
    {
        $create_action_serv = $container->get('CreateActionService');
        $create_match_serv  = $container->get('CreateMatchService');
        try {
            $action = $create_action_serv->execute(new CreateActionRequest(
                $request->retrive('type'),
                $request->retrive('sender_id'),
                $request->retrive('receiver_id')
            ));

            $match = $create_match_serv->execute(new CreateMatchRequest(
                $request->retrive('sender_id'),
                $request->retrive('receiver_id')
            ));

            if($match)
            {
                Response::asJson([ 'result' => 'Match found', 'match' => $match ]);
            }
        } catch(\Exception $e) {
            Response::asJson([ 'error' => $e->getMessage() ]);
        }
    }
}
