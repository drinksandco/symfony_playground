<?php

namespace Obokaman\Playground\Application\Service\User;

use Obokaman\Playground\Application\Service\ApplicationService;
use Obokaman\Playground\Domain\Infrastructure\Repository\User\UserRepository;
use Obokaman\Playground\Domain\Model\User\Email;
use Obokaman\Playground\Domain\Model\User\UserId;

class EditUser implements ApplicationService
{
    /** @var UserRepository */
    private $user_repo;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repo = $a_user_repository;
    }

    public function __invoke(EditUserRequest $an_edit_user_request)
    {
        $user_id = new UserId($an_edit_user_request->user_id);
        $user    = $this->user_repo->find($user_id);

        $user->changeName($an_edit_user_request->name);
        $user->changeEmail(new Email($an_edit_user_request->email));

        // Acquire two new random skills.
        $user->acquireSkill(AddUser::RANDOM_SKILLS[rand(0, 2)]);
        $user->acquireSkill(AddUser::RANDOM_SKILLS[rand(3, 4)]);

        // Forget 1 random skill.
        $user_skills            = $user->skills();
        $random_skill_to_forget = $user_skills[array_rand($user_skills)];
        $user->forgetSkill($random_skill_to_forget);

        $this->user_repo->persist($user);
    }
}
