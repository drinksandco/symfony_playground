<?php

namespace UserManager\Domain\Infrastructure\Cache\Exception;

class InvalidCacheKeyException extends \DomainException
{
    const PREFIX = 'Invalid cache key: ';
    
    public function __construct($message)
    {
        parent::__construct(self::PREFIX . $message);
    }
}
