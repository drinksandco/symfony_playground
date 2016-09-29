<?php

namespace Workshop\UserBundle\Controller;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Workshop\UserBundle\Repository\UserRepository;

class AddUserService
{
    /**
     * @var EventDispatcherInterface
     */
    private $an_event_dispatcher;

    public function __construct(EventDispatcherInterface $an_event_dispatcher)
    {
        $this->an_event_dispatcher = $an_event_dispatcher;
    }

    public function __invoke(array $user)
    {
        $users_repo = new UserRepository();
        $users_repo->signInUser($user);

        $user_added = new UserAdded();
        $this->an_event_dispatcher->dispatch("user.added", $user_added);

		return;
    }
}
