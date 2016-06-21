<?php

namespace Workshop\UserBundle\src\Application\Service\User\Add;

use Workshop\UserBundle\src\Domain\Model\Email\Email;
use Workshop\UserBundle\src\Domain\Repository\User\UserRepository;
use Workshop\UserBundle\src\Domain\Model\User\User;

final class AddUserUseCase
{
    /** @var UserRepository */
    private $user_repository;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repository = $a_user_repository;
    }
    
    public function __invoke(AddUserRequest $add_user_request)
    {
        $new_user = User::register(
            $add_user_request->name(), 
            $add_user_request->surname(), 
            $add_user_request->username(), 
            new Email($add_user_request->email())
        );
        
        return $this->user_repository->add($new_user);
    }    
}