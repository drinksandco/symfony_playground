<?php

namespace Playground\App\Infrastructure\Repository\Doctrine\Skill;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Playground\App\Domain\Model\Skill\SkillId;
use Playground\App\Infrastructure\Repository\Doctrine\AggregateIdCustomType;
use Ramsey\Uuid\Uuid;

final class SkillIdCustomType extends AggregateIdCustomType
{
    const ID_FIELD_NAME = 'skill_id';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $uuid = (Uuid::fromBytes($value))->toString();

        return new SkillId($uuid);
    }
}
