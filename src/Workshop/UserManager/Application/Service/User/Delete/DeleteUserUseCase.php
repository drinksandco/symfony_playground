<?php

namespace UserManager\Application\Service\User\Delete;

use UserManager\Domain\Model\User\ValueObject\UserId;
use UserManager\Domain\Infrastructure\Repository\User\UserRepository;

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
