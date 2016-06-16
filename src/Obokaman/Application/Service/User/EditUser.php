<?php

namespace Obokaman\Application\Service\User;

use Obokaman\Domain\Infrastructure\Repository\User\UserRepository;
use Obokaman\Domain\User\Email;
use Obokaman\Domain\User\UserId;

class EditUser
{
    /** @var UserRepository */
    private $user_repo;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repo = $a_user_repository;
    }

    public function __invoke(EditUserRequest $an_edit_user_request)
    {
        $user_id = new UserId($an_edit_user_request->user_id);
        $user    = $this->user_repo->find($user_id);

        if ($an_edit_user_request->name != $user->name())
        {
            $user->changeName($an_edit_user_request->name);
        }

        if (!$user->email()->equals($an_edit_user_request->email))
        {
            $email = new Email($an_edit_user_request->email);
            $user->changeEmail($email);
        }

        $this->user_repo->persist($user);
    }
}
