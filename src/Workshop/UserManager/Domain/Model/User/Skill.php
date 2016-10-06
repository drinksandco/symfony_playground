<?php

namespace Workshop\UserManager\Domain\Model\User;

final class Skill
{
    /** @var SkillId */
    private $skill_id;

    /** @var string */
    private $name;

    public function __construct(SkillId $an_skill_id, string $a_name)
    {
        $this->skill_id = $an_skill_id;
        $this->name = $a_name;
    }

    public static function create(string $a_skill_name)
    {
        $skill_id = SkillId::generate();
        return new self($skill_id, $a_skill_name);
    }

    public function skillId()
    {
        return $this->skill_id;
    }

    public function name()
    {
        return $this->name;
    }
}
