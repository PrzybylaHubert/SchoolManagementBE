<?php

namespace App\Utils\FormModel;

use App\Utility\ErrorList;
use Symfony\Component\Validator\Constraints as Assert;

class ResetPasswordExecuteValidate
{
    #[Assert\NotBlank(message: 'Field password cannot be empty.')]
    #[Assert\Length(min: 8, minMessage: 'Password needs to be at least {{ limit }} characters long.')]
    private ?string $password = null;

    #[Assert\NotBlank(message: ErrorList::INVALID_TOKEN)]
    #[Assert\Length(min: 16, max: 16, exactMessage: ErrorList::INVALID_TOKEN)]
    private ?string $selector = null;

    #[Assert\NotBlank(message: ErrorList::INVALID_TOKEN)]
    #[Assert\Length(min: 64, max: 64, exactMessage: ErrorList::INVALID_TOKEN)]
    #[Assert\Regex(pattern: '/^[a-f0-9]+$/i', message: ErrorList::INVALID_TOKEN)]
    private ?string $token = null;

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSelector(): ?string
    {
        return $this->selector;
    }

    public function setSelector(string $selector): self
    {
        $this->selector = $selector;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }
}
