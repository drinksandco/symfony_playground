<?php

namespace Playground\App\Infrastructure\Repository\Doctrine\User;

use Doctrine\DBAL\Connection;
use Playground\App\Domain\Infrastructure\Repository\User\UserRepository as UserRepositoryContract;
use Playground\App\Domain\Kernel\EventRecorder;
use Playground\App\Domain\Model\Skill\Skill;
use Playground\App\Domain\Model\Skill\SkillCollection;
use Playground\App\Domain\Model\Skill\SkillId;
use Playground\App\Domain\Model\User\Email;
use Playground\App\Domain\Model\User\Event\UserRemoved;
use Playground\App\Domain\Model\User\User;
use Playground\App\Domain\Model\User\UserId;

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
        $sql = <<<SQL
REPLACE INTO user (id, name, email, creation_date, update_date) VALUES (:user_id, :name, :email, :creation_date, :update_date);
SQL;

        $statement = $this->db->prepare($sql);

        $user_id       = (string) $a_user->userId();
        $name          = $a_user->name();
        $email         = (string) $a_user->email();
        $creation_date = $a_user->creationDate()->format('Y-m-d H:i:s');
        $update_date   = $a_user->updateDate()->format('Y-m-d H:i:s');

        $statement->bindParam('user_id', $user_id, \PDO::PARAM_STR);
        $statement->bindParam('name', $name, \PDO::PARAM_STR);
        $statement->bindParam('email', $email, \PDO::PARAM_STR);
        $statement->bindParam('creation_date', $creation_date, \PDO::PARAM_STR);
        $statement->bindParam('update_date', $update_date, \PDO::PARAM_STR);

        $statement->execute();

        $this->persistSkills($a_user);

        if (true === $flush)
        {
            $this->flush();
        }
    }

    private function persistSkills(User $a_user)
    {
        $this->removeUserSkills($a_user->userId());

        $user_id = (string) $a_user->userId();

        /** @var Skill $skill */
        foreach ($a_user->skills() as $skill)
        {
            $skill_id          = (string) $skill->skillId();
            $skill_description = $skill->description();

            $sql       = <<<SQL
INSERT INTO skill (id, description) VALUES ( :skill_id, :skill_description );
SQL;
            $statement = $this->db->prepare($sql);
            $statement->bindParam('skill_id', $skill_id, \PDO::PARAM_STR);
            $statement->bindParam('skill_description', $skill_description, \PDO::PARAM_STR);
            $statement->execute();

            $sql       = <<<SQL
INSERT INTO user_skill (user_id, skill_id) VALUES ( :user_id, :skill_id );
SQL;
            $statement = $this->db->prepare($sql);
            $statement->bindParam('user_id', $user_id, \PDO::PARAM_STR);
            $statement->bindParam('skill_id', $skill_id, \PDO::PARAM_STR);
            $statement->execute();
        }
    }

    public function remove(UserId $a_user_id, $flush = true)
    {
        $this->removeUserSkills($a_user_id);

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

        EventRecorder::instance()->recordEvent(new UserRemoved($a_user_id));
    }

    public function flush()
    {
        $this->db->commit();
    }

    /** @return User[] */
    private function hydrateItems(array $results): array
    {
        $users = [];
        foreach ($results as $result)
        {
            $user = $this->hydrateItem($result);
            array_push($users, $user);
        }

        return $users;
    }

    private function hydrateItem(array $result): User
    {
        $user_id = new UserId($result['id']);

        $skills = $this->hydrateSkills($user_id);

        $user = new User(
            $user_id,
            $result['name'],
            new Email($result['email']),
            new \DateTimeImmutable($result['creation_date']),
            new \DateTimeImmutable($result['update_date']),
            $skills
        );

        return $user;
    }

    private function hydrateSkills(UserId $user_id): SkillCollection
    {
        $skills = new SkillCollection();

        $sql = <<<SQL
SELECT
    s.*
FROM
    user_skill us
        JOIN skill s ON s.id = us.skill_id
WHERE
    us.user_id = :user_id
SQL;

        $statement = $this->db->prepare($sql);
        $statement->bindParam('user_id', $user_id, \PDO::PARAM_STR);
        $statement->execute();

        $results = $statement->fetchAll();


        if (empty($results))
        {
            return $skills;
        }

        foreach ($results as $skill)
        {
            $skills->addItem(new Skill(new SkillId($skill['id']), $skill['description']));
        }

        return $skills;

    }

    private function removeUserSkills(UserId $a_user_id)
    {
        $user_id = $a_user_id->id();

        $sql = <<<SQL
DELETE
FROM 
    skill 
WHERE
    id IN ( SELECT skill_id FROM user_skill WHERE user_id = :user_id )
SQL;

        $statement = $this->db->prepare($sql);
        $statement->bindParam('user_id', $user_id, \PDO::PARAM_STR);

        $statement->execute();

        $sql = <<<SQL
DELETE FROM user_skill WHERE user_id = :user_id
SQL;
        $statement = $this->db->prepare($sql);
        $statement->bindParam('user_id', $user_id, \PDO::PARAM_STR);

        $statement->execute();

    }
}
