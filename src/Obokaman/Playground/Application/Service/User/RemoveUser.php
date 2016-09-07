<?php

namespace Obokaman\Playground\Application\Service\User;

use Obokaman\Playground\Application\Service\ApplicationService;
use Obokaman\Playground\Domain\Infrastructure\Repository\User\UserRepository;
use Obokaman\Playground\Domain\Model\User\UserId;

class RemoveUser implements ApplicationService
{
    /** @var UserRepository */
    private $user_repo;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repo = $a_user_repository;
    }

    public function __invoke($a_user_id)
    {
        $user_id = new UserId($a_user_id);
        $this->user_repo->remove($user_id);
    }
}
