<?php

namespace Obokaman\Application\Service\User;

use Obokaman\Domain\Infrastructure\Repository\User\UserRepository;
use Obokaman\Domain\Model\User\Email;
use Obokaman\Domain\Model\User\Event\UserEmailChanged;
use Obokaman\Domain\Model\User\Event\UserNameChanged;
use Obokaman\Domain\Model\User\UserId;
use Obokaman\Domain\Service\EventDispatcher;

class EditUser
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

    public function __invoke(EditUserRequest $an_edit_user_request)
    {
        $user_id = new UserId($an_edit_user_request->user_id);
        $user    = $this->user_repo->find($user_id);

        if ($an_edit_user_request->name != $user->name())
        {
            $user->changeName($an_edit_user_request->name);
            $this->event_dispatcher->dispatch(new UserNameChanged((string) $user_id));
        }

        if (!$user->email()->equals($an_edit_user_request->email))
        {
            $email = new Email($an_edit_user_request->email);
            $user->changeEmail($email);
            $this->event_dispatcher->dispatch(new UserEmailChanged((string) $user_id));
        }

        $this->user_repo->persist($user);
    }
}
