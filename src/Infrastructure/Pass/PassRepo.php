<?php

namespace App\Infrastructure\Pass;

use Ramsey\Uuid\Uuid;
use Domino\Interfaces\PersistenceInterface;
use App\Domain\Pass\{
    PassId\PassId,
    PassId\PassIdInterface,
    Pass,
    PassRepoInterface
};
use App\Infrastructure\User\UserRepo;
use App\Domain\User\UserId\UserId;


class PassRepo implements PassRepoInterface
{
    private $persist;

    private $passes = [];


    public function __construct(PersistenceInterface $persist)
    {
        $this->persist = $persist;
    }

    public function nextId()
    {
        return new PassId(strtoupper(Uuid::uuid4()));
    }

    public function add(Pass $pass)
    {
        $this->persist->table('passes')->create([
            'id'         => $pass->getId(),
            'owner'      => $pass->getOwner()->getId(),
            'receiver'   => $pass->getReceiver()->getId(),
            'created_on' => $pass->getCreatedOn()
        ]);
    }

    public function addAll(Array $passes)
    {
        foreach($passes as $pass)
        {
            $this->add($pass);
        }
    }

    public function remove(Pass $pass)
    {
        $this->persist->table('passes')->where('id', (string) $pass->getId())->delete();
    }

    public function removeAll(Array $passes)
    {
        foreach($passes as $pass)
        {
            $this->remove($pass);
        }
    }

    public function withId(PassIdInterface $id)
    {
        $pass = $this->persist->table('passes')->where('id', $id)->selectOne();
        if($pass)
        {
            $user_repo = new UserRepo($this->persist);
            return new Pass(
                new PassId($pass['id']),
                $user_repo->withId(new UserId($pass['owner'])),
                $user_repo->withId(new UserId($pass['receiver'])),
                $pass['created_on']
            );
        }
        return null;
    }

    public function withOwnerId(PassIdInterface $id)
    {
        $passes = $this->persist->table('passes')->where('owner', (string) $id->getId())->select();

        if(count($passes) > 0)
        {
            $user_repo = new UserRepo($this->persist);
            foreach($passes as $pass)
            {
                $this->passes[] = new Pass(
                    new PassId($pass['id']),
                    $user_repo->withId(new UserId($pass['owner'])),
                    $user_repo->withId(new UserId($pass['receiver'])),
                    $pass['created_on']
                );
            }
            return $this->passes;
        }
        return null;
    }
}
