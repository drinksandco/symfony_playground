<?php

namespace User\Domain;

interface SkillRepository
{
    public function findById(SkillId $a_skill_id);

    public function findAll();

    public function nextIdentity() : SkillId;
}
