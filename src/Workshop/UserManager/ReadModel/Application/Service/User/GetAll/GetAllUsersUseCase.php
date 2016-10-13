<?php

namespace UserManager\ReadModel\Application\Service\User\GetAll;

use UserManager\Domain\Infrastructure\Repository\User\UserRepository;

final class GetAllUsersUseCase
{
    /** @var UserRepository */
    private $user_repository;

    /** @var GetAllMarshaller */
    private $get_all_marshaller;

    public function __construct(UserRepository $a_user_repository, GetAllMarshaller $a_get_all_marshaller)
    {
        $this->user_repository = $a_user_repository;
        $this->get_all_marshaller = $a_get_all_marshaller;
    }

    public function __invoke(GetAllUsersRequest $a_request)
    {
        $user_collection = $this->user_repository->findAll();

        return $this->get_all_marshaller->__invoke($user_collection);
    }
}
