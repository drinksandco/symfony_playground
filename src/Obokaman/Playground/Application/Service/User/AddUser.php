<?php

namespace Obokaman\Playground\Application\Service\User;

use Obokaman\Playground\Application\Service\ApplicationService;
use Obokaman\Playground\Domain\Infrastructure\Repository\User\UserRepository;
use Obokaman\Playground\Domain\Model\User\User;

class AddUser implements ApplicationService
{
    /** @var UserRepository */
    private $user_repo;

    const RANDOM_SKILLS = [
        'read',
        'swim',
        'play soccer',
        'programming',
        'english'
    ];

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repo = $a_user_repository;
    }

    public function __invoke(AddUserRequest $a_request)
    {
        $user = User::create($a_request->name(), $a_request->email());

        foreach ($a_request->skills() as $skill)
        {
            $user->acquireSkill($skill);
        }

        $this->user_repo->persist($user);

        return $user;
    }
}
