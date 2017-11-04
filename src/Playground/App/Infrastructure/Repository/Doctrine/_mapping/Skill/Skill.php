<?php

namespace Playground\App\Infrastructure\Repository\Doctrine\_mapping\Skill;

use Playground\App\Domain\Model\Skill\SkillId;

/**
 * Skill
 */
class Skill
{
    /**
     * @var SkillId
     */
    private $id;

    /**
     * @var string
     */
    private $description;


    /**
     * Set id
     *
     * @param SkillId $id
     *
     * @return Skill
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return SkillId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Skill
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}

