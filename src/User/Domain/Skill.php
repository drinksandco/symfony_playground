<?php

namespace User\Domain;

final class Skill
{
    /** @var string */
    private $name;

    public function __construct(string $a_name)
    {
        $this->name = $a_name;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }
}
