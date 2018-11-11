<?php

namespace App\Infrastructure\Pass;

use Ramsey\Uuid\Uuid;
use Domino\Interfaces\PersistenceInterface;
use App\Domain\Pass\{
    PassId\PassId,
    Pass,
    PassRepoInterface
};
use App\Infrastructure\User\UserRepo;
use App\Domain\User\UserId\UserId;


class PassRepo implements PassRepoInterface
{
    private $persist;


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

    public function withId($id)
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
}
