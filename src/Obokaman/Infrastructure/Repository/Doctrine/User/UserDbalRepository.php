<?php

namespace Obokaman\Infrastructure\Repository\Doctrine\User;

use Doctrine\DBAL\Connection;
use Obokaman\Domain\Infrastructure\Repository\User\UserRepository as UserRepositoryContract;
use Obokaman\Domain\Kernel\EventStore;
use Obokaman\Domain\Model\User\Email;
use Obokaman\Domain\Model\User\Event\UserRemoved;
use Obokaman\Domain\Model\User\User;
use Obokaman\Domain\Model\User\UserId;

class UserDbalRepository implements UserRepositoryContract
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
SELECT * FROM user WHERE id = :id_user
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
SELECT * FROM user ORDER BY creation_date ASC;
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

    public function persist(User $a_user, $flush = true)
    {
        if (!$this->db->isTransactionActive())
        {
            $this->db->beginTransaction();
        }

        $sql = <<<SQL
REPLACE INTO user (id, name, email, creation_date) VALUES (:user_id, :name, :email, :creation_date);
SQL;

        $statement = $this->db->prepare($sql);

        $user_id       = (string) $a_user->userId();
        $name          = $a_user->name();
        $email         = (string) $a_user->email();
        $creation_date = $a_user->creationDate()->format('Y-m-d H:i:s');
        $statement->bindParam('user_id', $user_id, \PDO::PARAM_STR);
        $statement->bindParam('name', $name, \PDO::PARAM_STR);
        $statement->bindParam('email', $email, \PDO::PARAM_STR);
        $statement->bindParam('creation_date', $creation_date, \PDO::PARAM_STR);

        $statement->execute();

        if (true === $flush)
        {
            $this->flush();
        }
    }

    public function remove(UserId $a_user_id, $flush = true)
    {
        if (!$this->db->isTransactionActive())
        {
            $this->db->beginTransaction();
        }

        $sql = <<<SQL
DELETE FROM user WHERE id = :user_id;
SQL;

        $statement = $this->db->prepare($sql);

        $user_id = (string) $a_user_id;
        $statement->bindParam('user_id', $user_id, \PDO::PARAM_STR);

        $statement->execute();

        if (true === $flush)
        {
            $this->flush();
        }

        EventStore::instance()->storeEvent(new UserRemoved((string) $a_user_id));
    }

    public function flush()
    {
        $this->db->commit();
    }

    /** @return User[] */
    private function hydrateItems($results)
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
        $user = new User(
            new UserId($result['id']), $result['name'], new Email($result['email']), new \DateTimeImmutable($result['creation_date'])
        );

        return $user;
    }
}