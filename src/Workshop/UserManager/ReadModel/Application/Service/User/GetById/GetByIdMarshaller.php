<?php

namespace UserManager\ReadModel\Application\Service\User\GetById;

use UserManager\Domain\Model\User\User;

interface GetByIdMarshaller
{
    public function __invoke(User $a_user);
}
