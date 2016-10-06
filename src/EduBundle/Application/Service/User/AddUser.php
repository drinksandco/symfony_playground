<?php

namespace EduBundle\Application\Service\User;

use EduBundle\Domain\Infrastructure\Repository\User\UserRepository;
use EduBundle\Domain\Model\User\Email;
use EduBundle\Domain\Model\User\User;

final class AddUser
{
    /** @var UserRepository */
    private $user_repository;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repository = $a_user_repository;
    }

    public function __invoke()
    {
        $random_identifier = rand(1, 10000);
        $user              = User::create("Edu " . $random_identifier, new Email("edu" . $random_identifier . "@gmail.com"));
        $this->user_repository->persist($user);

        return $user;
    }
}
