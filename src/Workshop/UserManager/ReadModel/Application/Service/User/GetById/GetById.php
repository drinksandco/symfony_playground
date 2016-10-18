<?php

namespace UserManager\ReadModel\Application\Service\User\GetById;

use UserManager\Domain\Infrastructure\Repository\User\UserRepository;
use UserManager\Domain\Model\User\UserId;

class GetById
{
    /** @var UserRepository */
    private $user_repository;

    /** @var GetByIdMarshaller */
    private $get_by_id_marshaller;

    public function __construct(UserRepository $a_user_repository, GetByIdMarshaller $a_get_by_id_marshaller)
    {
        $this->user_repository      = $a_user_repository;
        $this->get_by_id_marshaller = $a_get_by_id_marshaller;
    }

    public function __invoke(GetByIdRequest $a_request)
    {
        $raw_user_id = $a_request->userId();

        $user = $this->user_repository->findById(new UserId($raw_user_id));

        return $this->get_by_id_marshaller->__invoke($user);
    }
}
