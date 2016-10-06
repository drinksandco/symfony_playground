<?php

namespace User\Domain;

final class User
{
    /** @var UserId */
    private $id;

    /** @var string */
    private $name;

    /** @var array */
    private $skills;

    public function __construct(
        UserId $an_id,
        string $a_name,
        array $some_skills
    )
    {
        $this->id     = $an_id;
        $this->name   = $a_name;
        $this->skills = $some_skills;
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
     * @return array
     */
    public function skills()
    {
        return $this->skills;
    }

}
