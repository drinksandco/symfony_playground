<?php

namespace UserManager\Infrastructure\Repository\Doctrine\Dbal\User;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDOException;
use UserManager\Domain\Infrastructure\Repository\User\UserRepository as UserRepositoryContract;
use UserManager\Domain\Model\Email\Email;
use UserManager\Domain\Model\User\User;
use UserManager\Domain\Model\User\ValueObject\UserId;
use UserManager\Domain\Model\User\UserCollection;
use UserManager\Domain\Model\User\ValueObject\Username;

final class UserRepository implements UserRepositoryContract
{
    /** @var Connection */
    private $dbal_connection;

    public function __construct(Connection $a_dbal_connection)
    {
        $this->dbal_connection = $a_dbal_connection;
    }

    public function findAll()
    {
        $query = <<<SQL
SELECT 
  u.id,
  u.name,
  u.surname,
  u.email,
  u.username
 
FROM users u;

SQL;

        $result = $this->dbal_connection->fetchAll($query);

        $user_collection = new UserCollection();

        if (empty($result))
        {
            return $user_collection;
        }

        foreach ($result as $user)
        {
            $user_collection->add(User::fromExistent(new UserId($user['id']), $user['name'], $user['surname'], new Username($user['username']), new Email($user['email'])));
        }

        return $user_collection;
    }

    public function findById(UserId $user_id)
    {
        $user_id = $user_id->userId();

        $query = <<<SQL
SELECT 
  u.id,
  u.name,
  u.surname,
  u.email,
  u.username
 
FROM 
    users u;

WHERE 
    u.id = $user_id
SQL;
        $statement = $this->dbal_connection->executeQuery($query);

        $result = $statement->fetch();

        if (empty($result))
        {
            return null;
        }

        return User::fromExistent(new UserId($result['id']), $result['name'], $result['surname'], new Username($result['username']), new Email($result['email']));
    }

    public function add(User $a_new_user)
    {
        $user_id = $a_new_user->userId()->userId();
        $name = $a_new_user->name();
        $surname = $a_new_user->surname();
        $username = $a_new_user->username()->username();
        $email = $a_new_user->email()->email();

        $query = <<<SQL

INSERT INTO users (`id`, `name`, `surname`, `username`, `email`) VALUES (:user_id, :name, :surname, :username, :email);

SQL;
        try
        {
            $this->dbal_connection->beginTransaction();

            $statement = $this->dbal_connection->prepare($query);

            $statement->bindParam(':user_id', $user_id, \PDO::PARAM_STR);
            $statement->bindParam(':name', $name, \PDO::PARAM_STR);
            $statement->bindParam(':surname', $surname, \PDO::PARAM_STR);
            $statement->bindParam(':username', $username, \PDO::PARAM_STR);
            $statement->bindParam(':email', $email, \PDO::PARAM_STR);

            $statement->execute();

            $this->dbal_connection->commit();

            return $this->dbal_connection->lastInsertId();
        }
        catch (PDOException $exception)
        {
            $this->dbal_connection->rollBack();
        }
    }

    public function update(User $a_user)
    {
        $user_id = $a_user->userId()->userId();
        $name = $a_user->name();
        $surname = $a_user->surname();
        $username = $a_user->username()->username();
        $email = $a_user->email()->email();

        $query = <<<SQL
UPDATE 
    users

SET 
    name=:name,
    surname=:surname,
    username=:username,
    email=:email 

WHERE
    id = :user_id

SQL;
        try
        {
            $this->dbal_connection->beginTransaction();

            $statement = $this->dbal_connection->prepare($query);

            $statement->bindParam(':user_id', $user_id, \PDO::PARAM_STR);
            $statement->bindParam(':name', $name, \PDO::PARAM_STR);
            $statement->bindParam(':surname', $surname, \PDO::PARAM_STR);
            $statement->bindParam(':username', $username, \PDO::PARAM_STR);
            $statement->bindParam(':email', $email, \PDO::PARAM_STR);

            $statement->execute();

            $this->dbal_connection->commit();
        }
        catch (PDOException $exception)
        {
            $this->dbal_connection->rollBack();
            return false;
        }
    }

    public function delete(UserId $user_id)
    {
        $user_id_to_delete = $user_id->userId();

        $query = <<<SQL
DELETE FROM 
    users
WHERE
    id = :user_id
SQL;

        try
        {
            $this->dbal_connection->beginTransaction();

            $statement = $this->dbal_connection->prepare($query);

            $statement->bindParam(':user_id', $user_id_to_delete, \PDO::PARAM_STR);

            $statement->execute();

            $this->dbal_connection->commit();

            return true;
        }
        catch (PDOException $exception)
        {
            return false;
        }
    }
}
