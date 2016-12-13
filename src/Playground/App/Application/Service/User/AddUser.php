<?php

namespace Playground\App\Application\Service\User;

use Playground\App\Domain\Infrastructure\Repository\User\UserRepository;
use Playground\App\Domain\Model\User\User;

class AddUser
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

    public function __invoke(AddUserCommand $a_command)
    {
        $user = User::create($a_command->userId(), $a_command->name(), $a_command->email());

        foreach ($a_command->skills() as $skill)
        {
            $user->acquireSkill($skill);
        }

        $this->user_repo->persist($user);

        return $user;
    }
}
