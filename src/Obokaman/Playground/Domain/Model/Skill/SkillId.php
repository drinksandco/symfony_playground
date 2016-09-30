<?php

namespace Obokaman\Playground\Domain\Model\Skill;

use Ramsey\Uuid\Uuid;

final class SkillId
{
    /** @var string */
    private $skill_id;

    public function __construct(string $a_skill_id)
    {
        $this->skill_id = $a_skill_id;
    }

    public static function generateUniqueId()
    {
        return new self(Uuid::uuid4());
    }

    public function skillId()
    {
        return $this->skill_id;
    }

    public function __toString()
    {
        return $this->skill_id;
    }
}
