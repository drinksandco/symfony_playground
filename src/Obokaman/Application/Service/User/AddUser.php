<?php

namespace Obokaman\Application\Service\User;

use Obokaman\Domain\Infrastructure\Repository\User\UserRepository;
use Obokaman\Domain\Model\User\Email;
use Obokaman\Domain\Model\User\Event\UserCreated;
use Obokaman\Domain\Model\User\User;
use Obokaman\Domain\Model\User\UserId;
use Obokaman\Domain\Service\EventDispatcher;

class AddUser
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

    public function __invoke()
    {
        $user_id    = UserId::generateUniqueId();
        $user_name  = "Pepote " . rand(1, 10000);
        $user_email = new Email("pepote." . rand(1, 10000) . "@gmail.com");

        $user = new User($user_id, $user_name, $user_email);

        $this->user_repo->persist($user);

        $this->event_dispatcher->dispatch(new UserCreated((string) $user_id));

        return $user;
    }
}
