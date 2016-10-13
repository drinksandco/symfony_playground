<?php

namespace UserManager\Domain\Model\User;

final class Skill
{
    /** @var SkillId */
    private $skill_id;

    /** @var string */
    private $name;

    /** @var string */
    private $type;

    public function __construct(SkillId $an_skill_id, string $a_name, string $a_type)
    {
        $this->skill_id = $an_skill_id;
        $this->name = $a_name;
        $this->type = $a_type;
    }

    public static function create(string $a_skill_name, string $a_skill_type)
    {
        $skill_id = SkillId::generate();
        return new self($skill_id, $a_skill_name, $a_skill_type);
    }

    public function skillId()
    {
        return $this->skill_id;
    }

    public function name()
    {
        return $this->name;
    }

    public function type()
    {
        return $this->type;
    }
}
