<?php

namespace Obokaman\Domain\Model\User;

use Ramsey\Uuid\Uuid;

class UserId
{
    /** @var string */
    private $user_id;

    public function __construct(string $a_user_id)
    {
        $this->user_id = $a_user_id;
    }

    public static function generateUniqueId()
    {
        return new self(Uuid::uuid4());
    }

    public function userId()
    {
        return $this->user_id;
    }

    public function __toString()
    {
        return $this->user_id;
    }
}
