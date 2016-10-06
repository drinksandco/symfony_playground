<?php

namespace EduBundle\Application\Service\User;

use EduBundle\Domain\Infrastructure\Repository\User\UserRepository;

final class ListUsers
{
    /** @var UserRepository */
    private $user_repository;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repository = $a_user_repository;
    }

    public function __invoke()
    {
        $users = $this->user_repository->findAll();

        dump($users);

        return $users;
    }
}
