<?php

namespace Obokaman\Playground\Domain\Model\User;

class Email
{
    /** @var string */
    private $email;

    public function __construct(string $an_email)
    {
        $email = mb_strtolower($an_email);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            throw new \InvalidArgumentException('Email "' . $email . '" has an invalid format');
        }

        $this->email = $email;
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
        return $this->email === $an_email->email();
    }
}
