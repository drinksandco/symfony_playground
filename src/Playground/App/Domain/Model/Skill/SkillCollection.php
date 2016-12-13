<?php

namespace Playground\App\Domain\Model\Skill;

use Playground\App\Domain\Kernel\Collection;

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
