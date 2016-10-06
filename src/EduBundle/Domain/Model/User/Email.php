<?php

namespace EduBundle\Domain\Model\User;

final class Email
{
    /** @var string */
    private $email;

    public function __construct(string $an_email)
    {
        $this->email = $an_email;
    }

    public function email()
    {
        return $this->email;
    }
}
