<?php

namespace App\Application\User\AttachImage;

use App\Domain\User\UserRepoInterface;
use App\Domain\User\Image\ImageRepoInterface;
use App\Domain\User\UserId\UserId;
use App\Domain\User\Image\ImageFactory;


class AttachImageService
{
    private $user_repo;

    private $image_repo;


    public function __construct(
        UserRepoInterface $user_repo,
        ImageRepoInterface $image_repo)
    {
        $this->user_repo  = $user_repo;
        $this->image_repo = $image_repo;
    }

    public function execute(AttachImageRequestInterface $request)
    {
        $user = $this->user_repo->withId(new UserId($request->user_id));
        if($user)
        {
            $image = ImageFactory::build(
                (string) $this->image_repo->nextId(),
                $request->user_id,
                $request->image_path
            );
            $user->addImage($image);

            $this->user_repo->add($user);

            return $user;
        }
        return null;
    }
}
