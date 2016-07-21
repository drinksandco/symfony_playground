<?php

namespace UserManager\ReadModel\Application\Service\User\GetById;

use UserManager\Domain\Model\User\User;

class UserToArrayMarshaller implements GetByIdMarshaller
{
    public function __invoke(User $a_user)
    {
        return [
            'id'       => $a_user->userId()->userId(),
            'name'     => $a_user->name(),
            'surname'  => $a_user->surname(),
            'username' => $a_user->username(),
            'email'    => $a_user->email()->email()
        ];
    }
}
