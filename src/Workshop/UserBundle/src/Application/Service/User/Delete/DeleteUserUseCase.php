<?php

namespace Workshop\UserBundle\src\Application\Service\User\Delete;

use Workshop\UserBundle\src\Domain\Model\User\ValueObject\UserId;
use Workshop\UserBundle\src\Domain\Repository\User\UserRepository;

class DeleteUserUseCase
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
        
        return $this->user_repository->delete($user_id);
    }   
}
