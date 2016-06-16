<?php

namespace UserBundle\Repository;

use Doctrine\DBAL\Connection;

class UserRepository
{
    /** @var  Connection */
    private $dbal;

    public function __construct(Connection $a_dbal_driver)
    {
        $this->dbal = $a_dbal_driver;
    }

    public function getAllUsers()
    {
        $results = $this->dbal->fetchAll("SELECT * FROM test");
        
        return $results;
    }
}
