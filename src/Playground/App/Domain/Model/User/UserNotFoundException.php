<?php

namespace Playground\App\Domain\Model\User;

final class UserNotFoundException extends \DomainException
{
    public function __construct(UserId $a_user_id)
    {
        $this->message = "User ID " . $a_user_id . " doesn't exists.";
    }
}
