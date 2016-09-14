<?php

namespace UserManager\Domain\Model\User\Exception;

class InvalidUsernameException extends \DomainException
{
    const MESSAGE_PREFIX = 'Invalid username for: ';

    public function __construct($message)
    {
        parent::__construct(self::MESSAGE_PREFIX . $message);
    }
}
