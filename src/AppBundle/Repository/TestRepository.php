<?php

namespace AppBundle\Repository;

use Doctrine\DBAL\Connection;

class TestRepository
{
    /** @var  Connection */
    private $dbal;

    public function __construct(Connection $a_dbal_driver)
    {
        $this->dbal = $a_dbal_driver;
    }

    public function getAllThings()
    {
        $results = $this->dbal->fetchAll("SELECT * FROM test");
        
        return $results;
    }
}
