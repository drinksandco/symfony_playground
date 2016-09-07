<?php

namespace Obokaman\Playground\Application\Service\User;

use Obokaman\Playground\Application\Service\ApplicationService;
use Obokaman\Playground\Domain\Infrastructure\Repository\User\UserRepository;
use Obokaman\Playground\Domain\Model\User\Email;
use Obokaman\Playground\Domain\Model\User\User;

class AddUser implements ApplicationService
{
    /** @var UserRepository */
    private $user_repo;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repo = $a_user_repository;
    }

    public function __invoke()
    {
        $user_name  = "Pepote " . rand(1, 10000);
        $user_email = new Email("pepote." . rand(1, 10000) . "@gmail.com");

        $user = User::create($user_name, $user_email);

        $this->user_repo->persist($user);

        return $user;
    }
}
