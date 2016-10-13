<?php

namespace Workshop\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class DoctrineUser
{
    /** @var string */
    private $user_id;

    /** @var string */
    private $name;

    /** @var string */
    private $surname;

    /** @var string */
    private $username;

    /** @var string */
    private $email;

    /** @var ArrayCollection */
    private $skills;

    public function __construct(string $a_user_id, string $a_name, string $a_surname, string $a_username, string $an_email, ArrayCollection $some_skills = null)
    {
        if (empty($some_skills))
        {
            $this->skills = new ArrayCollection();
        }

        $this->user_id  = $a_user_id;
        $this->name     = $a_name;
        $this->surname  = $a_surname;
        $this->username = $a_username;
        $this->email    = $an_email;
        $this->skills   = $some_skills;
    }

    public function userId()
    {
        return $this->user_id;
    }

    public function setUserId(string $a_user_id)
    {
        $this->user_id = $a_user_id;
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

    public function surname()
    {
        return $this->surname;
    }

    public function setSurname(string $a_surname)
    {
        $this->surname = $a_surname;
        return $this;
    }

    public function username()
    {
        return $this->username;
    }

    public function setUsername(string $a_username)
    {
        $this->username = $a_username;
        return $this;
    }

    public function email()
    {
        return $this->email;
    }

    public function setEmail(string $an_email)
    {
        $this->email = $an_email;
    }

    public function skills()
    {
        return $this->skills;
    }

    public function addSkill(DoctrineSkill $skill)
    {
        $this->skills->add($skill);
        return $this;
    }
}
