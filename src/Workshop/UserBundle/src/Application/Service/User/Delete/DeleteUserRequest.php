<?php

namespace Workshop\UserBundle\src\Application\Service\User\Delete;

class DeleteUserRequest
{
    /** @var string */
    private $user_id;

    public function __construct(string $a_raw_user_id)
    {
        $this->user_id = $a_raw_user_id;
    }

    public function userId()
    {
        return $this->user_id;
    }
}
