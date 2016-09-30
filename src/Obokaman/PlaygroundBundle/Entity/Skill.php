<?php

namespace Obokaman\PlaygroundBundle\Entity;

/**
 * Skill
 */
class Skill
{
    /**
     * @var string
     */
    private $skill_id;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \Obokaman\PlaygroundBundle\Entity\User
     */
    private $user;


    /**
     * Set skillId
     *
     * @param string $skillId
     *
     * @return Skill
     */
    public function setSkillId($skillId)
    {
        $this->skill_id = $skillId;

        return $this;
    }

    /**
     * Get skillId
     *
     * @return string
     */
    public function getSkillId()
    {
        return $this->skill_id;
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

    /**
     * Set user
     *
     * @param \Obokaman\PlaygroundBundle\Entity\User $user
     *
     * @return Skill
     */
    public function setUser(\Obokaman\PlaygroundBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Obokaman\PlaygroundBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
