<?php

namespace Obokaman\Application\Service\User;

use Obokaman\Domain\Infrastructure\Repository\User\UserRepository;
use Obokaman\Domain\User\Email;
use Obokaman\Domain\User\User;
use Obokaman\Domain\User\UserId;

class AddUser
{
    /** @var UserRepository */
    private $user_repo;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repo = $a_user_repository;
    }

    public function __invoke()
    {
        $user_id    = UserId::generateUniqueId();
        $user_name  = "Pepote " . rand(1, 10000);
        $user_email = new Email("pepote." . rand(1, 10000) . "@gmail.com");

        $user = new User($user_id, $user_name, $user_email);

        $this->user_repo->persist($user);

        return $user;
    }
}
