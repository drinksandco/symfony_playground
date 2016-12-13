<?php

namespace Playground\App\Application\Service\User;

use Playground\App\Domain\Infrastructure\Repository\User\UserRepository;

class ListUsers
{
    /** @var UserRepository */
    private $user_repo;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repo = $a_user_repository;
    }

    public function __invoke()
    {
        $users = $this->user_repo->findAll();

        return $users;
    }
}
