<?php

namespace User\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class User
{
    /** @var UserId */
    private $id;

    /** @var string */
    private $name;

    /** @var Collection */
    private $skills;

    public function __construct(
        UserId $an_id,
        string $a_name
    )
    {
        $this->id     = $an_id;
        $this->name   = $a_name;
        $this->skills = new ArrayCollection();
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
     * @return Collection
     */
    public function skills()
    {
        return $this->skills;
    }

}
