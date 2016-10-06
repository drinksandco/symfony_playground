<?php

namespace Workshop\UserManager\Domain\Model\User;

final class SkillId
{
    /** @var string */
    private $skill_id;

    public function __construct($a_raw_skill_id)
    {
        $this->skill_id = $a_raw_skill_id;
    }

    public static function generate()
    {
        return new self(uniqid('workshop-bundles'));
    }

    public function skillId()
    {
        return $this->skill_id;
    }
}
