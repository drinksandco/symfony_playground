<?php

namespace User\Domain;

interface UserRepository
{
    public function findById(UserId $a_user_id);

    public function findAll();

    public function nextIdentity() : UserId;
}
