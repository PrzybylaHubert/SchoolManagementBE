<?php

namespace App\Security;

use App\Entity\Doctor;
use App\Entity\Kid;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user->isActive()) {
            throw new CustomUserMessageAccountStatusException('User inactive.');
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
    }
}
