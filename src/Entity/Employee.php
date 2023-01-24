<?php

namespace App\Entity;

class Employee extends User implements UserTypeInterface
{
    public function setType(): self
    {
        $this->type = 'employee';

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }
}
