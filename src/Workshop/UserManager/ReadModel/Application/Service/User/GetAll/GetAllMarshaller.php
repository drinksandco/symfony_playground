<?php

namespace UserManager\ReadModel\Application\Service\User\GetAll;

use UserManager\Domain\Model\User\UserCollection;

interface GetAllMarshaller
{
    public function __invoke(UserCollection $user_collection);
}
