<?php

namespace App\User;

use Symfony\Component\Validator\Constraints as Assert;

class UserCreateRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2)]
    public string $firstName;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2)]
    public string $lastName;

    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;
}
