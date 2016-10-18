<?php

namespace UserManager\Application\Service\User\Add;

use UserManager\Application\Service\Core\ApplicationService;
use UserManager\Domain\Infrastructure\Repository\User\UserRepository;
use UserManager\Domain\Model\Email\Email;
use UserManager\Domain\Model\User\Skill;
use UserManager\Domain\Model\User\SkillCollection;
use UserManager\Domain\Model\User\User;
use UserManager\Domain\Model\User\Username;

final class AddUser implements ApplicationService
{
    /** @var UserRepository */
    private $user_repository;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repository = $a_user_repository;
    }

    public function __invoke(AddUserRequest $a_request)
    {
        $skill_collection = $this->getSkillCollection($a_request->skills());

        $new_user = User::register(
            $a_request->name(),
            $a_request->surname(),
            new Username($a_request->username()),
            new Email($a_request->email()),
            $skill_collection
        );

        $new_user_id = $this->user_repository->persist($new_user, true);

        return $new_user_id;
    }

    private function getSkillCollection($raw_skills)
    {
        $skill_collection = new SkillCollection();

        if (empty($raw_skills))
        {
            return $skill_collection;
        }

        foreach ($raw_skills as $raw_skill)
        {
            $skill_collection->add(Skill::create($raw_skill['name']));
        }

        return $skill_collection;
    }
}
