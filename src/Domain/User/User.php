<?php

namespace App\Domain\User;

use JsonSerializable;
use App\Domain\User\UserId\UserIdInterface;
use App\Domain\User\Name\NameInterface;
use App\Domain\User\BirthDate\BirthDateInterface;
use App\Domain\User\Gender\GenderInterface;
use App\Domain\User\Email\EmailInterface;
use App\Domain\User\Password\PasswordInterface;
use App\Domain\User\Action\ActionInterface;
use App\Domain\User\Token\TokenInterface;
use App\Domain\User\Image\ImageInterface;
use App\Domain\CreatedOn\CreatedOn;
use App\Domain\CreatedOn\CreatedOnInterface;


class User implements UserInterface, JsonSerializable
{
    private $id;

    private $name;

    private $birth_date;

    private $gender;

    private $email;

    private $password;

    private $actions = [];

    private $images = [];

    private $token;

    private $created_on;


    public function __construct(
        UserIdInterface $id,
        NameInterface $name,
        BirthDateInterface $birth_date,
        GenderInterface $gender,
        EmailInterface $email,
        PasswordInterface $password,
        CreatedOnInterface $created_on)
    {
        $this->id         = $id;
        $this->name       = $name;
        $this->birth_date = $birth_date;
        $this->gender     = $gender;
        $this->email      = $email;
        $this->password   = $password;
        $this->created_on = $created_on;
    }

    private function assertActionSenderMatchUser(ActionInterface $action)
    {
        if(!(string) $action->getSenderId() === (string) $this->getId())
        {
            throw new \Exception('Action sender must be the parent user', 1);
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(NameInterface $name)
    {
        $this->name = $name;
    }

    public function getBirthDate()
    {
        return $this->birth_date;
    }

    public function setBirthDate(BirthDateInterface $birth_date)
    {
        $this->birth_date = $birth_date;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender(GenderInterface $gender)
    {
        $this->gender = $gender;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(EmailInterface $email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(PasswordInterface $password)
    {
        $this->password = $password;
    }

    public function getCreatedOn()
    {
        return $this->created_on;
    }

    public function addToken(TokenInterface $token = null)
    {
        $this->token = $token;
    }

    public function getToken()
    {
        if($this->token !== null)
        {
            return $this->token;
        }
        return null;
    }

    public function addAction(ActionInterface $action)
    {
        $this->assertActionSenderMatchUser($action);

        $this->actions[] = $action;
    }

    public function addActions(Array $actions)
    {
        foreach($actions as $action)
        {
            $this->addAction($action);
        }
    }

    public function getActions()
    {
        return $this->actions;
    }

    public function countActions()
    {
        return count($this->getActions());
    }

    public function getLikes()
    {
        $likes = [];
        foreach($this->getActions() as $action)
        {
            if($action->isLike())
            {
                $likes[] = $action;
            }
        }
        return $likes;
    }

    public function getPasses()
    {
        $passes = [];
        foreach($this->getActions() as $action)
        {
            if($action->isPass())
            {
                $passes[] = $action;
            }
        }
        return $passes;
    }

    public function likesUser(UserIdInterface $user_id)
    {
        foreach($this->getLikes() as $like)
        {
            if($like->getReceiverId()->isEqual($user_id))
            {
                return true;
            }
        }
        return false;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function addImage(ImageInterface $image)
    {
        $this->images[] = $image;
    }

    public function addImages(Array $images)
    {
        foreach($images as $image)
        {
            $this->addImage($image);
        }
    }

    public function countImages()
    {
        return count($this->getImages());
    }

    public function jsonSerialize()
    {
        return [
            'id'         => (string) $this->getId(),
            'name'       => (string) $this->getName(),
            'birth_date' => $this->getBirthDate(),
            'gender'     => (string) $this->getGender(),
            'email'      => (string) $this->getEmail(),
            'password'   => (string) $this->getPassword(),
            'images'     => $this->getImages(),
            'likes'      => $this->getLikes(),
            'passes'     => $this->getPasses(),
            'created_on' => (string) $this->getCreatedOn()
        ];
    }
}
