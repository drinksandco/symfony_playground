<?php

namespace UserManager\Application\Service\User\Update;

use UserManager\Application\Service\Core\ApplicationService;
use UserManager\Domain\Infrastructure\Repository\User\UserRepository;
use UserManager\Domain\Model\Email\Email;
use UserManager\Domain\Model\User\Skill;
use UserManager\Domain\Model\User\SkillCollection;
use UserManager\Domain\Model\User\SkillId;
use UserManager\Domain\Model\User\User;
use UserManager\Domain\Model\User\UserId;

final class UpdateUser implements ApplicationService
{
    /** @var UserRepository */
    private $user_repository;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repository = $a_user_repository;
    }

    public function __invoke(UpdateUserRequest $a_request)
    {
        $user = $this->user_repository->findById(new UserId($a_request->userId()));

        if (!$user instanceof User)
        {
            return null;
        }

        $user->changeName($a_request->name());
        $user->changeSurname($a_request->surname());
        $user->changeEmail(new Email($a_request->email()));

        $skills_collection = $this->getSkillCollection($a_request->skills());
        $user->changeSkills($skills_collection);

        $this->user_repository->persist($user);
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
            $skill_collection->add(new Skill(new SkillId($raw_skill['skill_id']), $raw_skill['name']));
        }

        return $skill_collection;
    }
}
