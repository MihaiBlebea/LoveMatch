<?php

namespace App\Domain\User;

use App\Domain\User\UserId\UserIdInterface;
use App\Domain\User\Name\NameInterface;
use App\Domain\User\BirthDate\BirthDateInterface;
use App\Domain\User\Gender\GenderInterface;
use App\Domain\User\Email\EmailInterface;
use App\Domain\User\Location\LocationInterface;
use App\Domain\User\Password\PasswordInterface;
use App\Domain\User\Action\ActionInterface;
use App\Domain\User\Token\TokenInterface;
use App\Domain\User\Image\ImageInterface;
use App\Domain\User\Description\DescriptionInterface;
use App\Domain\CreatedOn\CreatedOnInterface;


interface UserInterface
{
    public function __construct(
        UserIdInterface $id,
        NameInterface $name,
        BirthDateInterface $birth_date,
        GenderInterface $gender,
        EmailInterface $email,
        LocationInterface $location,
        PasswordInterface $password,
        CreatedOnInterface $created_on);

    public function getId();

    public function getName();

    public function setName(NameInterface $name);

    public function getBirthDate();

    public function setBirthDate(BirthDateInterface $birth_date);

    public function getGender();

    public function setGender(GenderInterface $gender);

    public function getEmail();

    public function setEmail(EmailInterface $email);

    public function getLocation();

    public function setLocation(LocationInterface $location);

    public function getPassword();

    public function setPassword(PasswordInterface $password);

    public function getCreatedOn();

    public function addToken(TokenInterface $token = null);

    public function getToken();

    public function addAction(ActionInterface $action);

    public function addActions(Array $actions);

    public function getActions();

    public function countActions();

    public function getLikes();

    public function getPasses();

    public function getImages();

    public function addImage(ImageInterface $image);

    public function addImages(Array $images);

    public function countImages();

    public function addDescription(DescriptionInterface $description);

    public function getDescription();

    public function addDistance(Int $distance);

    public function getDistance();

    public function addAgeInterval(Int $min, Int $max);

    public function getAgeInterval();

    public function jsonSerialize();
}
