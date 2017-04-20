<?php

namespace Playground\App\Infrastructure\Repository\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Playground\App\Domain\Model\AggregateId;
use Ramsey\Uuid\Uuid;

abstract class AggregateIdCustomType extends Type
{
    const ID_FIELD_NAME = null;

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return "BINARY(16)";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        throw new \DomainException('You should implement method ' . __METHOD__ . ' on ' . __CLASS__);
    }

    /**
     * @param AggregateId      $value
     * @param AbstractPlatform $platform
     *
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        $uuid = Uuid::fromString((string) $value);

        return $uuid->getBytes();
    }

    public function getName()
    {
        return static::ID_FIELD_NAME;
    }
}
