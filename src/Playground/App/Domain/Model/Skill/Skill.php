<?php

namespace Playground\App\Domain\Model\Skill;

final class Skill
{
    /** @var SkillId */
    private $id;

    /** @var string */
    private $description;

    public function __construct(SkillId $a_skill_id, $a_description)
    {
        $this->id          = $a_skill_id;
        $this->description = $a_description;
    }

    public static function learn($a_description)
    {
        $skill_id = SkillId::generateUniqueId();

        return new self($skill_id, $a_description);
    }

    public function skillId()
    {
        return $this->id;
    }

    public function description()
    {
        return $this->description;
    }
}
