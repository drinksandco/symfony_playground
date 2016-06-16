<?php

namespace Workshop\UserBundle\src\Domain\User\ValueObject;

final class UserId
{
    /** @var string */
    private $user_id;

    public function __construct($a_raw_user_id)
    {
        $this->user_id = $a_raw_user_id;
    }

    public static function generate()
    {
        return new self(uniqid('workshop-bundles'));
    }

    public function userId()
    {
        return $this->user_id;
    }
}
