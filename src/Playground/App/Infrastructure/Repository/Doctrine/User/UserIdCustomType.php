<?php

namespace Playground\App\Infrastructure\Repository\Doctrine\User;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Playground\App\Domain\Model\User\UserId;
use Playground\App\Infrastructure\Repository\Doctrine\AggregateIdCustomType;
use Ramsey\Uuid\Uuid;

final class UserIdCustomType extends AggregateIdCustomType
{
    const ID_FIELD_NAME = 'user_id';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $uuid = (Uuid::fromBytes($value))->toString();

        return new UserId($uuid);
    }
}
