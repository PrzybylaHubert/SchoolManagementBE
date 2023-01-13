<?php

namespace App\Security;

use App\Utility\ErrorList;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user->isActive()) {
            throw new CustomUserMessageAccountStatusException(ErrorList::USER_INACTIVE);
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
    }
}
