<?php

namespace User\Infrastructure\Repository\Doctrine;

use Doctrine\ORM\EntityRepository;
use Ramsey\Uuid\Uuid;
use User\Domain\SkillId;
use User\Domain\SkillRepository as SkillRepositoryInterface;

final class SkillRepository extends EntityRepository implements SkillRepositoryInterface
{
    public function findById(SkillId $a_skill_id)
    {
        $skill_id = (string) $a_skill_id;

        return parent::find($skill_id);
    }

    public function nextIdentity() : SkillId
    {
        return SkillId::fromString((string) Uuid::uuid4());
    }
}
