<?php

namespace App\Utility\FormModel;

use Symfony\Component\Validator\Constraints as Assert;

class ResetPasswordRequestValidate
{
    #[Assert\NotBlank(message: 'Field email cannot be empty.')]
    #[Assert\Email(message: 'Field email not valid.')]
    private ?string $email = null;

    #[Assert\NotBlank(message: 'Field link cannot be empty.')]
    private ?string $link = null;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }
}
