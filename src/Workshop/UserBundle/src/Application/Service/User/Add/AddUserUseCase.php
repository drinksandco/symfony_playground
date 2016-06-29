<?php

namespace Workshop\UserBundle\src\Application\Service\User\Add;

use Workshop\UserBundle\src\Domain\Model\Email\Email;
use Workshop\UserBundle\src\Domain\Repository\User\UserRepository;
use Workshop\UserBundle\src\Domain\Model\User\User;

final class AddUserUseCase
{
    /** @var UserRepository */
    private $user_repository;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repository = $a_user_repository;
    }

    public function __invoke(AddUserRequest $a_request)
    {
        $new_user = User::register(
            $a_request->name(),
            $a_request->surname(),
            $a_request->username(),
            new Email($a_request->email())
        );

        return $this->user_repository->add($new_user);
    }
}
