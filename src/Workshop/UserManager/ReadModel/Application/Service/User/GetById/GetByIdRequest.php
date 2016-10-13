<?php

namespace UserManager\ReadModel\Application\Service\User\GetById;

class GetByIdRequest
{
    /** @var string */
    private $user_id;
    
    public function __construct(string $a_user_id)
    {
        $this->user_id = $a_user_id;
    }

    public function userId()
    {
        return $this->user_id;
    }
}
