<?php

namespace Obokaman\Domain\Model\User;

class Email
{
    /** @var string */
    private $email;

    public function __construct(string $an_email)
    {
        $this->email = mb_strtolower($an_email);
    }

    public function email()
    {
        return $this->email;
    }

    public function __toString()
    {
        return $this->email;
    }

    public function equals(self $an_email)
    {
        return $this->email == $an_email->email();
    }
}
