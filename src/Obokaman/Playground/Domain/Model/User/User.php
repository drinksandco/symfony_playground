<?php

namespace Obokaman\Playground\Domain\Model\User;

use Obokaman\Playground\Domain\Kernel\EventRecorder;
use Obokaman\Playground\Domain\Model\Skill\Skill;
use Obokaman\Playground\Domain\Model\Skill\SkillId;
use Obokaman\Playground\Domain\Model\User\Event\UserCreated;
use Obokaman\Playground\Domain\Model\User\Event\UserEmailChanged;
use Obokaman\Playground\Domain\Model\User\Event\UserNameChanged;

class User
{
    /** @var UserId */
    private $user_id;

    /** @var string */
    private $name;

    /** @var Email */
    private $email;

    /** @var \DateTimeImmutable */
    private $creation_date;

    /** @var Skill[] */
    private $skills;

    public function __construct(
        UserId $a_user_id,
        $a_name,
        Email $an_email,
        \DateTimeImmutable $a_datetime,
        array $skills
    )
    {
        $this->user_id       = $a_user_id;
        $this->name          = $a_name;
        $this->email         = $an_email;
        $this->creation_date = $a_datetime;
        $this->skills        = $skills;
    }

    public static function create($a_name, Email $an_email)
    {
        $user_id  = UserId::generateUniqueId();
        $datetime = new \DateTimeImmutable('now');

        $user = new self($user_id, $a_name, $an_email, $datetime, []);

        EventRecorder::instance()->recordEvent(new UserCreated($user_id, $a_name, $an_email));

        return $user;
    }

    public function userId()
    {
        return $this->user_id;
    }

    public function name()
    {
        return $this->name;
    }

    public function email()
    {
        return $this->email;
    }

    public function creationDate()
    {
        return $this->creation_date;
    }

    public function skills()
    {
        return $this->skills;
    }

    public function hasSkill(SkillId $skill_id)
    {
        return isset($this->skills[(string) $skill_id]);
    }

    public function changeName($a_name)
    {
        if ($this->name == $a_name)
        {
            return;
        }

        EventRecorder::instance()->recordEvent(new UserNameChanged($this->user_id, $a_name));

        $this->name = $a_name;
    }

    public function changeEmail(Email $an_email)
    {
        if ($this->email->equals($an_email))
        {
            return;
        }

        EventRecorder::instance()->recordEvent(new UserEmailChanged($this->user_id, $an_email));

        $this->email = $an_email;
    }

    public function acquireSkill($skill_description)
    {
        $skill = Skill::learn($skill_description);

        $this->skills[(string) $skill->skillId()] = $skill;
    }

    public function forgetSkill(Skill $an_skill)
    {
        unset($this->skills[(string) $an_skill->skillId()]);
    }

    public function forgetSkills()
    {
        $this->skills = [];
    }
}
