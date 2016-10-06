<?php

namespace EduBundle\Infrastructure\Repository\DBAL\User;

use Doctrine\DBAL\Connection;
use EduBundle\Domain\Infrastructure\Repository\User\UserRepository as UserRepositoryContract;
use EduBundle\Domain\Model\User\Email;
use EduBundle\Domain\Model\User\User;
use EduBundle\Domain\Model\User\UserId;

final class UserRepository implements UserRepositoryContract
{
    /** @var Connection */
    private $db;


    public function __construct(Connection $a_dbal_connection)
    {
        $this->db = $a_dbal_connection;
    }

    public function find(UserId $a_user_id)
    {
        $sql = <<<SQL
SELECT 
    id_user,
    name,
    email
FROM 
    users 
WHERE 
    id = :id_user
SQL;

        $statement = $this->db->prepare($sql);

        $user_id = (string) $a_user_id;
        $statement->bindParam('id_user', $user_id, \PDO::PARAM_STR);

        $statement->execute();
        $results = $statement->fetchAll();

        if (empty($results))
        {
            return null;
        }

        return $this->hydrateItem($results[0]);
    }

    public function findAll()
    {
        $sql = <<<SQL
SELECT 
    id_user,
    name,
    email
FROM 
    users;
SQL;

        $statement = $this->db->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll();

        if (empty($results))
        {
            return [];
        }

        return $this->hydrateItems($results);
    }

    public function persist(User $a_user)
    {
        if (!$this->db->isTransactionActive())
        {
            $this->db->beginTransaction();
        }

        $sql = <<<SQL
REPLACE INTO users 
    (id_user, name, email) 
VALUES 
    (:user_id, :name, :email);
SQL;

        $statement = $this->db->prepare($sql);

        $user_id = $a_user->idUser()->userId();
        $name    = $a_user->name();
        $email   = $a_user->email()->email();
        $statement->bindParam('user_id', $user_id, \PDO::PARAM_STR);
        $statement->bindParam('name', $name, \PDO::PARAM_STR);
        $statement->bindParam('email', $email, \PDO::PARAM_STR);

        $statement->execute();

        $this->flush();
    }

    public function remove(UserId $a_user_id)
    {
        if (!$this->db->isTransactionActive())
        {
            $this->db->beginTransaction();
        }

        $sql = <<<SQL
DELETE FROM 
    users 
WHERE 
    id = :user_id;
SQL;

        $statement = $this->db->prepare($sql);

        $user_id = (string) $a_user_id;
        $statement->bindParam('user_id', $user_id, \PDO::PARAM_STR);

        $statement->execute();

        $this->flush();
    }

    public function flush()
    {
        $this->db->commit();
    }

    /**
     *
     *
     * @param array $results
     *
     * @return array
     */
    private function hydrateItems(array $results)
    {
        $users = [];
        foreach ($results as $result)
        {
            $user = $this->hydrateItem($result);
            array_push($users, $user);
        }

        return $users;
    }

    private function hydrateItem(array $result)
    {
        $user = new User(new UserId($result['id_user']), $result['name'], new Email($result['email']));

        return $user;
    }

}
