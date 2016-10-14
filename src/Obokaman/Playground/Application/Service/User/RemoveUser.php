<?php

namespace Obokaman\Playground\Application\Service\User;

use Obokaman\Playground\Domain\Infrastructure\Repository\User\UserRepository;

class RemoveUser
{
    /** @var UserRepository */
    private $user_repo;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repo = $a_user_repository;
    }

    public function __invoke(RemoveUserCommand $a_command)
    {
        $this->user_repo->remove($a_command->userId());
    }
}
