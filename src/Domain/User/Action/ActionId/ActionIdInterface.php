<?php

namespace App\Domain\User\Action\ActionId;


interface ActionIdInterface
{
    public function __construct(String $id);

    public function getId();

    public function isEqual(ActionIdInterface $id);

    public function __toString();
}
