<?php

namespace User\Domain;

final class User
{
    /** @var UserId */
    private $id;

    /** @var string */
    private $name;

    /** @var Skill */
    private $skill;

    public function __construct(
        UserId $an_id,
        string $a_name,
        Skill $a_skill
    )
    {
        $this->id    = $an_id;
        $this->name  = $a_name;
        $this->skill = $a_skill;
    }

    /**
     * @return UserId
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

    /**
     * @return Skill
     */
    public function skill()
    {
        return $this->skill;
    }

}
