<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/bootstrap.php';



use App\Application\User\UserRegister\UserRegisterRequest;


if($argv[1] === 'users')
{
    $users_count = 100;
    $register_serv = $container->get('UserRegisterService');
    foreach(range(0, $users_count) as $user)
    {

        $birthdate = '19' . mt_rand(70, 99) . '-0' . mt_rand(1, 9) . '-' . mt_rand(10, 26);
        $gender = mt_rand(0,1) === 0 ? 'FEMALE' : 'MALE';

        try {
            $user = $register_serv->execute(new UserRegisterRequest(
                'Test' . $user,
                $birthdate,
                $gender,
                'test' . $user . '@gmail.com',
                '26.096306',
                '44.439663',
                'intrex'
            ));
        } catch(\Exception $e) {
            dd($e->getMessage());
        }
    }
}
