<?php

namespace UserManager\Application\Service\User\Update;

use UserManager\Domain\Infrastructure\EventDispatcher\DomainEventDispatcher;
use UserManager\Domain\Infrastructure\Repository\User\UserRepository;
use UserManager\Domain\Model\Email\Email;
use UserManager\Domain\Model\User\User;
use UserManager\Domain\Model\User\ValueObject\UserId;
use Workshop\UserManager\Domain\Infrastructure\Event\User\UserUpdated;

final class UpdateUserUseCase
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
    
    public function __invoke(UpdateUserRequest $a_request)
    {
        $updated_user = User::fromExistent(
            new UserId($a_request->userId()), 
            $a_request->name(), 
            $a_request->surname(), 
            $a_request->username(), 
            new Email($a_request->email())
        );
        
        $this->user_repository->update($updated_user);
        
        $this->event_dispatcher->dispatch(new UserUpdated($a_request->userId()));
    }
}
