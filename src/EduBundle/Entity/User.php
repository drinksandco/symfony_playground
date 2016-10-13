<?php

namespace EduBundle\Entity;

use Ramsey\Uuid\Uuid;

/**
 * User
 */
class User
{
    /**
     * @var Uuid
     */
    private $id_user;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;


    /**
     * Set idUser
     *
     * @param string $id_user
     *
     * @return User
     */
    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return string
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}

