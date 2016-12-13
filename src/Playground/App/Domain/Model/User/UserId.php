<?php

namespace Playground\App\Domain\Model\User;

use Ramsey\Uuid\Uuid;

class UserId
{
    /** @var string */
    private $id;

    public function __construct(string $a_user_id)
    {
        $this->id = $a_user_id;
    }

    public static function generateUniqueId()
    {
        return new self(Uuid::uuid4());
    }

    public function userId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->id;
    }
}
