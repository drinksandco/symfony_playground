<?php

namespace Obokaman\Application\Service\User;

use Obokaman\Domain\Infrastructure\Repository\User\UserRepository;
use Obokaman\Domain\Model\User\Event\UserRemoved;
use Obokaman\Domain\Model\User\UserId;
use Obokaman\Domain\Service\EventDispatcher;

class RemoveUser
{
    /** @var UserRepository */
    private $user_repo;

    /** @var EventDispatcher */
    private $event_dispatcher;

    public function __construct(UserRepository $a_user_repository, EventDispatcher $an_event_dispatcher)
    {
        $this->user_repo        = $a_user_repository;
        $this->event_dispatcher = $an_event_dispatcher;
    }

    public function __invoke($a_user_id)
    {
        $user_id = new UserId($a_user_id);
        $this->user_repo->remove($user_id);
        $this->event_dispatcher->dispatch(new UserRemoved((string) $user_id));
    }
}
