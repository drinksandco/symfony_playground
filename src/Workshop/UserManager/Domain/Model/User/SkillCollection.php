<?php

namespace UserManager\Domain\Model\User;

final class SkillCollection
{
    /** @var Skill[] */
    private $skills;

    public function __construct(array $some_skills = [])
    {
        foreach ($some_skills as $skill)
        {
            $this->add($skill);
        }
    }

    public function first()
    {
        return $this->skills[0];
    }

    public function last()
    {
        return $this->skills[count($this->skills) - 1];
    }

    public function count()
    {
        return count($this->skills);
    }

    public function isEmpty()
    {
        return (count($this->skills) === 0);
    }

    public function items()
    {
        return $this->skills;
    }

    public function add(Skill $new_skill)
    {
        $this->skills[] = $new_skill;
    }

    public function toArray()
    {
        $raw_skills = [];

        if (!empty($this->skills))
        {
            foreach ($this->skills as $skill)
            {
                $raw_skills[] = [
                    'skill_id' => $skill->skillId()->skillId(),
                    'name'     => $skill->name()
                ];
            }
        }

        return $raw_skills;
    }
}
