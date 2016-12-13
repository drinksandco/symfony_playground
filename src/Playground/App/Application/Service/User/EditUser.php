<?php

namespace Playground\App\Application\Service\User;

use Playground\App\Domain\Infrastructure\Repository\User\UserRepository;

class EditUser
{
    /** @var UserRepository */
    private $user_repo;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repo = $a_user_repository;
    }

    public function __invoke(EditUserCommand $a_command)
    {
        $user = $this->user_repo->find($a_command->userId());

        $user->changeName($a_command->name());
        $user->changeEmail($a_command->email());

        // Acquire two new random skills.
        $user->acquireSkill(AddUser::RANDOM_SKILLS[rand(0, 2)]);
        $user->acquireSkill(AddUser::RANDOM_SKILLS[rand(3, 4)]);

        // Forget 1 random skill.
        $user_skills            = $user->skills()->items();
        $random_skill_to_forget = $user_skills[array_rand($user_skills)];
        $user->forgetSkill($random_skill_to_forget);

        $this->user_repo->persist($user);
    }
}
