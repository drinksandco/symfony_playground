<?php

namespace UserManager\Application\Service\User\Add;

use UserManager\Domain\Infrastructure\Event\User\UserAdded;
use UserManager\Domain\Infrastructure\EventDispatcher\DomainEventDispatcher;
use UserManager\Domain\Model\Email\Email;
use UserManager\Domain\Model\User\User;
use UserManager\Domain\Infrastructure\Repository\User\UserRepository;

final class AddUserUseCase
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

    public function __invoke(AddUserRequest $a_request)
    {
        $new_user = User::register(
            $a_request->name(),
            $a_request->surname(),
            $a_request->username(),
            new Email($a_request->email())
        );

        $new_user_id = $this->user_repository->add($new_user);

        $this->event_dispatcher->dispatch(new UserAdded($new_user_id));
    }
}
