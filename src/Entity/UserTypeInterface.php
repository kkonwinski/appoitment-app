<?php

namespace App\Entity;

interface UserTypeInterface
{
    public function setType(): self;

    public function getType(): ?string;
}
