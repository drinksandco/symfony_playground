<?php

namespace UserManager\Application\Service\User\Delete;

use UserManager\Domain\Infrastructure\Event\User\UserDeleted;
use UserManager\Domain\Model\User\ValueObject\UserId;
use UserManager\Domain\Infrastructure\Repository\User\UserRepository;
use UserManager\Application\Service\Core\ApplicationService;
use UserManager\Domain\Infrastructure\Event\DomainEventRecorder;

final class DeleteUserUseCase implements ApplicationService
{
    /** @var UserRepository */
    private $user_repository;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repository = $a_user_repository;
    }

    public function __invoke(DeleteUserRequest $a_request)
    {
        $user_id = new UserId($a_request->userId());

        $this->user_repository->delete($user_id);

        DomainEventRecorder::instance()->recordEvent(new UserDeleted($user_id->userId()));
    }
}
