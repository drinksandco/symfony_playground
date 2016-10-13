<?php

namespace User\Infrastructure\Doctrine\types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use User\Domain\Skill;

final class SkillType extends Type
{
    /**
     * Gets the SQL declaration snippet for a field of this type.
     *
     * @param array $fieldDeclaration                             The field declaration.
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform The currently used database platform.
     *
     * @return string
     */
    public function getSQLDeclaration(
        array $fieldDeclaration,
        AbstractPlatform $platform
    )
    {
        return 'SKILL';
    }

    /**
     * Gets the name of this type.
     *
     * @return string
     *
     */
    public function getName()
    {
        return 'skill';
    }

    public function convertToPHPValue(
        $value,
        AbstractPlatform $platform
    )
    {
        list($skill_name) = sscanf($value, 'SKILL(%s)');

        return new Skill($skill_name);
    }

    public function convertToDatabaseValue(
        $value,
        AbstractPlatform $platform
    )
    {
        if ($value instanceof Skill) {
            $value = sprintf('SKILL(%s)', $value->name());
        }

        return $value;
    }

    public function canRequireSQLConversion()
    {
        return true;
    }
}
