<?php

namespace Felipe\Entity;

class User
{
    public readonly int $id;
    public readonly string $email;
    public readonly string $password;
    public function __construct(string $email, string $password)
    {
    
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}