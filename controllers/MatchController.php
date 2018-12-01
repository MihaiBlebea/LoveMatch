<?php

namespace Controllers;

use Interceptor\Interfaces\RequestInterface;
use Interceptor\Response;
use League\Container\Container;

use App\Application\Match\GetMatches\GetMatchesRequest;
use App\Application\Match\CreateMatch\CreateMatchRequest;



class MatchController
{
    public function getUserMatches(RequestInterface $request, Container $container)
    {
        $get_match_serv = $container->get('GetMatchesService');
        try {
            $matches = $get_match_serv->execute(new GetMatchesRequest($request->retrive('user_id')));
            if($matches === null)
            {
                $matches = [];
            }
            Response::asJson($matches);
        } catch(\Exception $e) {
            Response::asJson([ 'error' => $e->getMessage() ]);
        }
    }

    public function createMatch(RequestInterface $request, Container $container)
    {
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
    }
}
