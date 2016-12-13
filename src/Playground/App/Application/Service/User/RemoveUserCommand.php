<?php

namespace Playground\App\Application\Service\User;

use Playground\App\Domain\Model\User\UserId;

final class RemoveUserCommand
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
