<?php

namespace EduBundle\Domain\Model\User;

final class User
{
    /** @var  UserId */
    private $id_user;

    /** @var  string */
    private $name;

    /** @var  Email */
    private $email;

    public function __construct(UserId $an_id_user, $a_name, Email $an_email)
    {
        $this->id_user = $an_id_user;
        $this->name    = $a_name;
        $this->email   = $an_email;
    }

    public static function create($a_name, Email $an_email)
    {
        $user_id = UserId::generateUniqueId();

        return new self($user_id, $a_name, $an_email);
    }

    /**
     * @return UserId
     */
    public function idUser()
    {
        return $this->id_user;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return Email
     */
    public function email()
    {
        return $this->email;
    }
}
