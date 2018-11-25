<?php

namespace App\Infrastructure\Persistence\User;

use Ramsey\Uuid\Uuid;
use App\Domain\User\User;
use App\Domain\User\UserInterface;
use App\Domain\User\UserFactory;
use App\Domain\User\UserRepoInterface;
use App\Domain\User\UserId\UserId;
use App\Domain\User\UserId\UserIdInterface;
use App\Domain\User\Email\EmailInterface;
use App\Domain\User\Token\TokenInterface;
use App\Domain\User\Token\Token;
use App\Domain\User\Gender\GenderInterface;
use App\Domain\User\Description\Description;
use App\Infrastructure\Persistence\Action\DominoActionRepo;
use App\Infrastructure\Persistence\Image\DominoImageRepo;


class DominoUserRepo implements UserRepoInterface
{
    private $users = [];

    private $persist;


    public function __construct($persist = null)
    {
        $this->persist = $persist;
    }

    public function nextId()
    {
        return new UserId(strtoupper(Uuid::uuid4()));
    }

    public function add(UserInterface $user)
    {
        $saved_user = $this->withId($user->getId());

        if($saved_user)
        {
            $this->persist->table('users')->where('id', (string) $saved_user->getId())->update([
                'name'        => (string) $user->getName(),
                'birth_date'  => (string) $user->getBirthDate(),
                'gender'      => (string) $user->getGender(),
                'description' => (string) $user->getDescription(),
                'email'       => (string) $user->getEmail(),
                'longitude'   => $user->getLocation()->getLongitude(),
                'latitude'    => $user->getLocation()->getLatitude(),
                'password'    => (string) $user->getPassword(),
                'token'       => $user->getToken() ? (string) $user->getToken() : null,
                'distance'    => $user->getDistance()->getDistance(),
                'min_age'     => $user->getAgeInterval()->getMin(),
                'max_age'     => $user->getAgeInterval()->getMax()
            ]);
        } else {
            $this->persist->table('users')->create([
                'id'          => (string) $user->getId(),
                'name'        => (string) $user->getName(),
                'birth_date'  => (string) $user->getBirthDate(),
                'gender'      => (string) $user->getGender(),
                'description' => (string) $user->getDescription(),
                'email'       => (string) $user->getEmail(),
                'longitude'   => $user->getLocation()->getLongitude(),
                'latitude'    => $user->getLocation()->getLatitude(),
                'password'    => (string) $user->getPassword()->getHashedPassword(),
                'token'       => $user->getToken() ? (string) $user->getToken() : null,
                'created_on'  => (string) $user->getCreatedOn(),
                'distance'    => $user->getDistance()->getDistance(),
                'min_age'     => $user->getAgeInterval()->getMin(),
                'max_age'     => $user->getAgeInterval()->getMax()
            ]);
        }

        // Save the actions in the action array
        if($user->countActions() > 0)
        {
            $action_repo = new DominoActionRepo($this->persist);
            $action_repo->addAll($user->getActions());
        }
        if($user->countImages() > 0)
        {
            $image_repo = new DominoImageRepo($this->persist);
            $image_repo->addAll($user->getImages());
        }

    }

    public function addAll(Array $users)
    {
        foreach($users as $user)
        {
            $this->add($user);
        }
    }

    public function remove(UserInterface $user)
    {
        $this->persist->table('users')->where('id', (string) $user->getId())->delete();
    }

    public function removeAll(Array $users)
    {
        foreach($users as $user)
        {
            $this->remove($user);
        }
    }

    private function buildUserAndDependencies(Array $row)
    {
        $user = UserFactory::build(
            $row['id'],
            $row['name'],
            $row['birth_date'],
            $row['gender'],
            $row['email'],
            $row['longitude'],
            $row['latitude'],
            $row['password'],
            $row['created_on']
        );

        // Get Auth token
        if($row['token'])
        {
            $user->addToken(new Token($row['token']));
        }

        // Get distance if not null
        if($row['distance'])
        {
            $user->addDistance($row['distance']);
        }

        // Get age interval if not null
        if($row['min_age'] && $row['max_age'])
        {
            $user->addAgeInterval($row['min_age'], $row['max_age']);
        }


        // get actions from repo
        $action_repo = new DominoActionRepo($this->persist);
        $actions = $action_repo->withSenderId($user->getId());

        if($actions && count($actions) > 0)
        {
            $user->addActions($actions);
        }

        // Get images from repo
        $image_repo = new DominoImageRepo($this->persist);
        $images = $image_repo->withUserId($user->getId());

        if($images && count($images) > 0)
        {
            $user->addImages($images);
        }

        // Add description to the object
        if($row['description'])
        {
            $user->addDescription(new Description($row['description']));
        }

        return $user;
    }

    public function withId(UserIdInterface $id)
    {
        $user = $this->persist->table('users')
                              ->where('id', (string) $id->getId())
                              ->selectOne();
        if($user)
        {
            return $this->buildUserAndDependencies($user);
        }
        return null;
    }

    public function withEmail(EmailInterface $email)
    {
        $user = $this->persist->table('users')
                              ->where('email', (string) $email->getEmail())
                              ->selectOne();
        if($user)
        {
            return $this->buildUserAndDependencies($user);
        }
        return null;
    }

    public function withToken(TokenInterface $token)
    {
        $user = $this->persist->table('users')
                              ->where('token', $token->getToken())
                              ->selectOne();
        if($user)
        {
            return $this->buildUserAndDependencies($user);
        }
        return null;
    }

    public function all(
        Int $count,
        String $gender,
        String $user_id,
        String $min_longitude,
        String $max_longitude,
        String $min_latitude,
        String $max_latitude,
        Int $distance,
        Int $min_age,
        Int $max_age)
    {
        // Calculate years from age
        // $min_year = \App\Domain\User\BirthDate\CalculateYearFromAgeService::execute($min_age);
        // $max_year = \App\Domain\User\BirthDate\CalculateYearFromAgeService::execute($max_age);
        $min_year = (string) \App\Domain\User\BirthDate\BirthDate::createFromAge($min_age);
        $max_year = (string) \App\Domain\User\BirthDate\BirthDate::createFromAge($max_age);


        $users = $this->persist->table('users')
                               ->where('gender', $gender)
                               ->where('id', '!=', $user_id)
                               ->where('longitude', '>', $min_longitude)
                               ->where('longitude', '<', $max_longitude)
                               ->where('latitude', '>', $min_latitude)
                               ->where('latitude', '<', $max_latitude)
                               ->where('birth_date', '>', $max_year)
                               ->where('birth_date', '<', $min_year)
                               ->limit($count)
                               ->select();
        if($users)
        {
            foreach($users as $user)
            {
                $this->users[] = $this->buildUserAndDependencies($user);
            }
            return $this->users;
        }
        return null;
    }
}
