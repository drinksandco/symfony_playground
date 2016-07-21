<?php

namespace UserManager\Domain\Model\User;

class UserCollection
{
    /** @var User[] */
    private $users;
    
    public function __construct(array $some_users = [])
    {
        $this->users = $some_users;
    }

    public function first()
    {
        return $this->users[0];
    }

    public function last()
    {
        return $this->users[count($this->users) -1];
    }

    public function count()
    {
        return count($this->users);
    }

    public function isEmpty()
    {
        return (count($this->users) === 0);
    }

    public function users()
    {
        return $this->users;
    }

    public function add(User $new_user)
    {
        $this->users[] = $new_user;
    }
}
