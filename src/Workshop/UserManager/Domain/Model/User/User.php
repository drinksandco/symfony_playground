<?php

namespace UserManager\Domain\Model\User;

use UserManager\Domain\Infrastructure\Event\DomainEventRecorder;
use UserManager\Domain\Infrastructure\Event\User\UserAdded;
use UserManager\Domain\Infrastructure\Event\User\UserHasUpdatedTheEmail;
use UserManager\Domain\Infrastructure\Event\User\UserHasUpdatedTheName;
use UserManager\Domain\Infrastructure\Event\User\UserHasUpdatedTheSurname;
use UserManager\Domain\Model\Email\Email;
use Workshop\UserManager\Domain\Infrastructure\Event\User\UserHasAddedANewSkill;
use Workshop\UserManager\Domain\Model\User\Skill;
use Workshop\UserManager\Domain\Model\User\SkillCollection;

final class User
{
    /** @var UserId */
    private $user_id;

    /** @var string */
    private $name;

    /** @var string */
    private $surname;

    /** @var Username */
    private $username;

    /** @var Email */
    private $email;

    /** @var SkillCollection */
    private $skills;

    private function __construct(UserId $a_user_id, $a_name, $a_surname, Username $a_username, Email $an_email, SkillCollection $some_skills)
    {
        $this->user_id = $a_user_id;
        $this->name = $a_name;
        $this->surname = $a_surname;
        $this->username = $a_username;
        $this->email = $an_email;
        $this->skills = $some_skills;
    }

    public static function register($a_name, $a_surname, Username $a_username, Email $an_email, SkillCollection $some_skills)
    {
        $new_user_id = UserId::generate();
        $new_user = new self($new_user_id, $a_name, $a_surname, $a_username, $an_email, $some_skills);

        DomainEventRecorder::instance()->recordEvent(new UserAdded($new_user));

        return $new_user;
    }

    public static function fromExistent(UserId $a_user_id, $a_name, $a_surname, Username $a_username, Email $an_email, SkillCollection $some_skills)
    {
        return new self($a_user_id, $a_name, $a_surname, $a_username, $an_email, $some_skills);
    }

    public function changeName($a_name)
    {
        if ($this->name === $a_name)
        {
            return $this;
        }

        $this->name = $a_name;

        DomainEventRecorder::instance()->recordEvent(new UserHasUpdatedTheName($this));

        return $this;
    }

    public function changeSurname($a_surname)
    {
        if ($this->surname === $a_surname)
        {
            return $this;
        }

        $this->surname = $a_surname;

        DomainEventRecorder::instance()->recordEvent(new UserHasUpdatedTheSurname($this));

        return $this;
    }

    public function changeEmail(Email $an_email)
    {
        if ($this->email->equals($an_email))
        {
            return $this;
        }

        $this->email = $an_email;

        DomainEventRecorder::instance()->recordEvent(new UserHasUpdatedTheEmail($this));

        return $this;
    }

    public function userId()
    {
        return $this->user_id;
    }

    public function name()
    {
        return $this->name;
    }

    public function surname()
    {
        return $this->surname;
    }

    public function username()
    {
        return $this->username;
    }

    public function email()
    {
        return $this->email;
    }

    public function skills()
    {
        return $this->skills;
    }

    public function addSkill(Skill $a_skill)
    {
        $this->skills->add($a_skill);
        DomainEventRecorder::instance()->recordEvent(new UserHasAddedANewSkill($this));
    }
}
