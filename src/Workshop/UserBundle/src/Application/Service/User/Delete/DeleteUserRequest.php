<?php

namespace Workshop\UserBundle\src\Application\Service\User\Delete;

class DeleteUserRequest
{
    /** @var integer */
    private $user_id;

    public function __construct($a_raw_user_id)
    {
        $this->user_id = $a_raw_user_id;
    }

    public function userId()
    {
        return $this->user_id;
    }
}
