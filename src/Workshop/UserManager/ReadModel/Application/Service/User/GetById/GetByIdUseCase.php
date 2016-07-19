<?php

namespace UserManager\ReadModel\Application\Service\User\GetById;

use UserManager\Domain\Infrastructure\Repository\User\UserRepository;
use UserManager\Domain\Model\User\ValueObject\UserId;

class GetByIdUseCase
{
    /** @var UserRepository */
    private $user_repository;
    
    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repository = $a_user_repository;
    }
    
    public function __invoke(GetByIdRequest $a_request)
    {
        $raw_user_id = $a_request->userId();
        
        return $this->user_repository->findById(new UserId($raw_user_id));
    }
}
