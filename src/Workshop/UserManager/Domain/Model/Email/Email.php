<?php

namespace UserManager\Domain\Model\Email;

final class Email
{
    /** @var string */
    private $email;

    public function __construct(string $a_raw_email)
    {
        $this->setEmail($a_raw_email);
    }

    public function setEmail(string $an_email)
    {
        $valid_email = filter_var($an_email, FILTER_VALIDATE_EMAIL);
        $this->email = $valid_email;
    }

    public function email()
    {
        return $this->email;
    }

    public function equals(Email $an_email)
    {
        return $this->email === $an_email->email();
    }
}
