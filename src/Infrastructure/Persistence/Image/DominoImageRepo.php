<?php

namespace App\Infrastructure\Persistence\Image;

use Ramsey\Uuid\Uuid;
use App\Domain\User\UserId\UserIdInterface;
use App\Domain\User\Image\ImageRepoInterface;
use App\Domain\User\Image\ImageInterface;
use App\Domain\User\Image\ImageFactory;
use App\Domain\User\Image\ImageId\ImageId;
use App\Domain\User\Image\ImageId\ImageIdInterface;


class DominoImageRepo implements ImageRepoInterface
{
    private $persist;

    private $images;


    public function __construct($persist = null)
    {
        $this->persist = $persist;
    }

    public function nextId()
    {
        return new ImageId(strtoupper(Uuid::uuid4()));
    }

    public function add(ImageInterface $image)
    {
        $saved_image = $this->withId($image->getId());

        if($saved_image)
        {
            $this->persist->table('images')->where('id', (string) $image->getId())->update([
                'user_id'    => (string) $image->getUserId(),
                'path'       => (string) $image->getPath()
            ]);
        } else {
            $this->persist->table('images')->create([
                'id'         => (string) $image->getId(),
                'user_id'    => (string) $image->getUserId(),
                'path'       => (string) $image->getPath(),
                'created_on' => (string) $image->getCreatedOn()
            ]);
        }
    }

    public function addAll(Array $images)
    {
        foreach($images as $image)
        {
            $this->add($image);
        }
    }

    public function remove(ImageInterface $image)
    {
        $result = $this->persist->table('images')
                      ->where('id', (string) $image->getId())
                      ->delete();
    }

    public function removeAll(Array $images)
    {
        foreach($images as $image)
        {
            $this->remove($image);
        }
    }

    public function withId(ImageIdInterface $id)
    {
        $image = $this->persist->table('images')
                               ->where('id', (string) $id->getId())
                               ->selectOne();

        if($image)
        {
            return $this->buildImage($image);
        }
    }

    public function withUserId(UserIdInterface $id)
    {
        $images = $this->persist->table('images')
                                ->where('user_id', (string) $id->getId())
                                ->select();

        if($images)
        {
            foreach($images as $image)
            {
                $this->images[] = $this->buildImage($image);
            }
            return $this->images;
        }
        return null;
    }

    private function buildImage(Array $row)
    {
        return ImageFactory::build(
            $row['id'],
            $row['user_id'],
            $row['path'],
            $row['created_on']
        );
    }
}
