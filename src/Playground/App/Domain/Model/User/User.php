<?php

namespace Playground\App\Domain\Model\User;

use Doctrine\Common\Collections\ArrayCollection;
use Playground\App\Domain\Kernel\EventRecorder;
use Playground\App\Domain\Model\Skill\Skill;
use Playground\App\Domain\Model\Skill\SkillCollection;
use Playground\App\Domain\Model\User\Event\UserCreated;
use Playground\App\Domain\Model\User\Event\UserEmailChanged;
use Playground\App\Domain\Model\User\Event\UserNameChanged;

class User
{
    private $id;
    private $name;
    private $email;
    private $creation_date;
    private $update_date;
    private $skills;

    public function __construct(
        UserId $a_user_id,
        string $a_name,
        Email $an_email,
        \DateTimeImmutable $a_creation_date,
        \DateTimeImmutable $an_update_date,
        SkillCollection $skills
    )
    {
        $this->id            = $a_user_id;
        $this->name          = $a_name;
        $this->email         = $an_email;
        $this->creation_date = $a_creation_date;
        $this->update_date   = $an_update_date;
        $this->skills        = new ArrayCollection($skills->items());
    }

    public static function create(UserId $a_user_id, $a_name, Email $an_email)
    {
        $creation_date = new \DateTimeImmutable();
        $update_date   = clone $creation_date;

        $user = new self($a_user_id, $a_name, $an_email, $creation_date, $update_date, new SkillCollection());

        EventRecorder::instance()->recordEvent(new UserCreated($a_user_id, $a_name, $an_email));

        return $user;
    }

    public function userId()
    {
        return $this->id;
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

    public function updateDate()
    {
        return $this->update_date;
    }

    public function skills()
    {
        return new SkillCollection($this->skills->toArray());
    }

    public function hasSkill(Skill $a_skill)
    {
        return $this->skills->contains($a_skill);
    }

    public function changeName($a_name)
    {
        if ($this->name == $a_name)
        {
            return;
        }

        EventRecorder::instance()->recordEvent(new UserNameChanged($this->id, $a_name));

        $this->name = $a_name;
        $this->refreshUpdateDate();
    }

    public function changeEmail(Email $an_email)
    {
        if ($this->email->equals($an_email))
        {
            return;
        }

        EventRecorder::instance()->recordEvent(new UserEmailChanged($this->id, $an_email));

        $this->email = $an_email;
        $this->refreshUpdateDate();
    }

    public function acquireSkill($skill_description)
    {
        $skill = Skill::learn($skill_description);

        $this->skills->add($skill);
        $this->refreshUpdateDate();
    }

    public function forgetSkill(Skill $an_skill)
    {
        $this->skills->removeElement($an_skill);
        $this->refreshUpdateDate();
    }

    public function forgetSkills()
    {
        $this->skills->clear();
        $this->refreshUpdateDate();
    }

    private function refreshUpdateDate()
    {
        $this->update_date = new \DateTimeImmutable();
    }
}
