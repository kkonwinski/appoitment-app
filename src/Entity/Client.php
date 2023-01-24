<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

class Client extends User implements UserTypeInterface
{
    public function setType(): self
    {
        $this->type = 'client';

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }
}
{

}
