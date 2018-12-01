<?php

namespace App\Domain\User;

use JsonSerializable;
use App\Domain\User\UserId\UserIdInterface;
use App\Domain\User\Name\NameInterface;
use App\Domain\User\Name\Name;
use App\Domain\User\BirthDate\BirthDateInterface;
use App\Domain\User\BirthDate\BirthDate;
use App\Domain\User\Gender\GenderInterface;
use App\Domain\User\Gender\Gender;
use App\Domain\User\Email\EmailInterface;
use App\Domain\User\Email\Email;
use App\Domain\User\Location\LocationInterface;
use App\Domain\User\Location\Location;
use App\Domain\User\Password\PasswordInterface;
use App\Domain\User\Password\Password;
use App\Domain\User\Action\ActionInterface;
use App\Domain\User\Token\TokenInterface;
use App\Domain\User\Image\ImageInterface;
use App\Domain\User\Description\DescriptionInterface;
use App\Domain\User\Distance\Distance;
use App\Domain\User\AgeInterval\AgeInterval;
use App\Domain\CreatedOn\CreatedOn;
use App\Domain\CreatedOn\CreatedOnInterface;


class User implements UserInterface, JsonSerializable
{
    private $id;

    private $name;

    private $birth_date;

    private $gender;

    private $email;

    private $location;

    private $password;

    private $actions = [];

    private $images = [];

    private $token;

    private $description;

    private $distance;

    private $age_interval;

    private $created_on;


    public function __construct(
        UserIdInterface $id,
        NameInterface $name,
        BirthDateInterface $birth_date,
        GenderInterface $gender,
        EmailInterface $email,
        LocationInterface $location,
        PasswordInterface $password,
        CreatedOnInterface $created_on)
    {
        $this->id         = $id;
        $this->name       = $name;
        $this->birth_date = $birth_date;
        $this->gender     = $gender;
        $this->email      = $email;
        $this->location   = $location;
        $this->password   = $password;
        $this->created_on = $created_on;

        // Default prferences values
        $this->distance     = new Distance(30);
        $this->age_interval = new AgeInterval(18, 65);
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

    public function setName(String $name)
    {
        $this->name = new Name($name);
    }

    public function getBirthDate()
    {
        return $this->birth_date;
    }

    public function setBirthDate(String $birth_date)
    {
        $this->birth_date = new BirthDate($birth_date);
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender(String $gender)
    {
        $this->gender = new Gender($gender);
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(String $email)
    {
        $this->email = new Email($email);
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation(String $long, String $lat)
    {
        $this->location = new Location($long, $lat);
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(String $password)
    {
        $this->password = new Password($password);
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

    public function getActionsUserIds() : Array
    {
        return array_map(function($action) {
            return (string) $action->getReceiverId();
        }, $this->getActions());
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

    public function addDescription(DescriptionInterface $description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function addDistance(Int $distance)
    {
        $this->distance = new Distance($distance);
    }

    public function getDistance()
    {
        return $this->distance;
    }

    public function addAgeInterval(Int $min, Int $max)
    {
        $this->age_interval = new AgeInterval($min, $max);
    }

    public function getAgeInterval()
    {
        return $this->age_interval;
    }

    public function jsonSerialize()
    {
        return [
            'id'          => (string) $this->getId(),
            'name'        => (string) $this->getName(),
            'birth_date'  => $this->getBirthDate(),
            'gender'      => (string) $this->getGender(),
            'description' => (string) $this->getDescription(),
            'email'       => (string) $this->getEmail(),
            'location'    => $this->getLocation(),
            'password'    => (string) $this->getPassword(),
            'images'      => $this->getImages(),
            'likes'       => $this->getLikes(),
            'passes'      => $this->getPasses(),
            'preferences' => [
                'distance' => (string) $this->getDistance(),
                'age'      => $this->age_interval ? $this->age_interval->getInterval() : null
            ],
            'created_on'  => (string) $this->getCreatedOn()
        ];
    }
}
