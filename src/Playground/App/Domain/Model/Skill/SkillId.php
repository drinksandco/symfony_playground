<?php

namespace Playground\App\Domain\Model\Skill;

use Ramsey\Uuid\Uuid;

final class SkillId
{
    /** @var string */
    private $id;

    public function __construct(string $a_skill_id)
    {
        $this->id = $a_skill_id;
    }

    public static function generateUniqueId()
    {
        return new self(Uuid::uuid4());
    }

    public function skillId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->id;
    }
}
