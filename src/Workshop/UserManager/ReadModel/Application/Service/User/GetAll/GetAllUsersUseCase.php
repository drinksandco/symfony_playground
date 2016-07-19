<?php

namespace UserManager\ReadModel\Application\Service\User\GetAll;

use UserManager\Domain\Infrastructure\Repository\User\UserRepository;

final class GetAllUsersUseCase
{
    /** @var UserRepository */
    private $user_repository;
    
    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repository = $a_user_repository;
    }

    public function __invoke(GetAllUsersRequest $a_request)
    {
        return $this->user_repository->findAll();
    }
}
