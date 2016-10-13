<?php

namespace Workshop\UserBundle\Entity;

class DoctrineSkill
{
    /** @var string */
    private $skill_id;

    /** @var string */
    private $name;

    /** @var string */
    private $type;

    /** @var DoctrineUser */
    private $user;

    public function __construct(string $a_skill_id, string $a_name, string $a_type, DoctrineUser $a_user)
    {
        $this->skill_id = $a_skill_id;
        $this->name = $a_name;
        $this->type = $a_type;
        $this->user = $a_user;
    }

    public function skillId()
    {
        return $this->skill_id;
    }

    public function setSkillId(string $a_skill_id)
    {
        $this->skill_id = $a_skill_id;
        return $this;
    }

    public function name()
    {
        return $this->name;
    }

    public function setName(string $a_name)
    {
        $this->name = $a_name;
        return $this;
    }

    public function type()
    {
        return $this->type;
    }

    public function setType(string $a_type)
    {
        $this->type = $a_type;
        return $this;
    }

    public function user()
    {
        return $this->user;
    }

    public function setUser(DoctrineUser $a_doctrine_user)
    {
        $this->user = $a_doctrine_user;
        return $this;
    }
}
