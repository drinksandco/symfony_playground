<?php

namespace User\Domain;

final class Skill
{
    /** @var SkillId */
    private $id;

    /** @var string */
    private $name;

    /** @var User */
    private $user;

    public function __construct(SkillId $an_id, string $a_name)
    {
        $this->id   = $an_id;
        $this->name = $a_name;
    }

    /**
     * @return SkillId
     */
    public function id()
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }
}
