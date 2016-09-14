<?php

namespace UserManager\Application\Service\User\Delete;

use UserManager\Domain\Infrastructure\Event\User\UserDeleted;
use UserManager\Domain\Infrastructure\EventDispatcher\DomainEventDispatcher;
use UserManager\Domain\Model\User\ValueObject\UserId;
use UserManager\Domain\Infrastructure\Repository\User\UserRepository;
use Workshop\UserManager\Application\Service\Core\ApplicationService;
use Workshop\UserManager\Domain\Infrastructure\Event\DomainEventRecorder;

final class DeleteUserUseCase implements ApplicationService
{
    /** @var UserRepository */
    private $user_repository;

    /** @var DomainEventDispatcher */
    private $event_dispatcher;

    public function __construct(UserRepository $a_user_repository, DomainEventDispatcher $an_event_dispatcher)
    {
        $this->user_repository = $a_user_repository;
        $this->event_dispatcher = $an_event_dispatcher;
    }

    public function __invoke(DeleteUserRequest $a_request)
    {
        $user_id = new UserId($a_request->userId());

        $this->user_repository->delete($user_id);

        DomainEventRecorder::getInstance()->recordEvent(new UserDeleted($user_id->userId()));
    }
}
