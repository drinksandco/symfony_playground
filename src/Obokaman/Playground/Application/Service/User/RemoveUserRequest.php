<?php

namespace Obokaman\Playground\Application\Service\User;

use Obokaman\Playground\Domain\Model\User\UserId;

final class RemoveUserRequest
{
    /** @var string */
    private $user_id;

    public function __construct($an_user_id)
    {
        $this->user_id = $an_user_id;
    }

    public function userId()
    {
        return new UserId($this->user_id);
    }
}
