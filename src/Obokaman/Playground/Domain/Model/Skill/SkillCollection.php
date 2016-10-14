<?php

namespace Obokaman\Playground\Domain\Model\Skill;

use Obokaman\Playground\Domain\Kernel\Collection;

final class SkillCollection extends Collection
{
    protected function getItemsClassName()
    {
        return Skill::class;
    }

    /** @param Skill $item */
    protected function getKey($item)
    {
        return (string) $item->skillId();
    }
}
