<?php

namespace App\Domain\User\Action\ActionId;


interface ActionIdInterface
{
    public function __construct($id);

    public function getId();

    public function __toString();
}
