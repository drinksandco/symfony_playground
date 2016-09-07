<?php

namespace Obokaman\Playground\Infrastructure\Repository\Doctrine\User;

use Doctrine\ORM\EntityManager;
use Obokaman\Playground\Domain\Infrastructure\Repository\User\UserRepository as UserRepositoryContract;
use Obokaman\Playground\Domain\Kernel\EventStore;
use Obokaman\Playground\Domain\Model\User\Email;
use Obokaman\Playground\Domain\Model\User\Event\UserRemoved;
use Obokaman\Playground\Domain\Model\User\User;
use Obokaman\Playground\Domain\Model\User\UserId;
use Obokaman\PlaygroundBundle\Entity\User as DoctrineUser;
use Obokaman\PlaygroundBundle\Repository\UserRepository as DoctrineUserRepository;

class UserRepository implements UserRepositoryContract
{
    /** @var EntityManager */
    private $em;

    /** @var DoctrineUserRepository */
    private $repo;

    public function __construct(EntityManager $an_entity_manager)
    {
        $this->em   = $an_entity_manager;
        $this->repo = $this->em->getRepository(DoctrineUser::class);
    }

    public function find(UserId $a_user_id)
    {
        $result = $this->repo->find((string) $a_user_id);

        return $this->hydrateItem($result);
    }

    public function findAll()
    {
        $results = $this->repo->findAll();

        return $this->hydrateItems($results);
    }

    public function persist(User $a_user, $flush = true)
    {
        $user = $this->repo->find((string) $a_user->userId());

        if (null === $user)
        {
            $user = new DoctrineUser();
        }

        $user->setId((string) $a_user->userId());
        $user->setEmail((string) $a_user->email());
        $user->setName($a_user->name());
        $user->setCreationDate(new \DateTime($a_user->creationDate()->format('Y-m-d H:i:s')));

        $this->em->persist($user);

        if (true === $flush)
        {
            $this->flush();
        }
    }

    public function remove(UserId $a_user_id, $flush = true)
    {
        $user = $this->repo->find((string) $a_user_id);

        if (null === $user)
        {
            return;
        }

        $this->em->remove($user);

        if (true === $flush)
        {
            $this->flush();
        }

        EventStore::instance()->storeEvent(new UserRemoved((string) $a_user_id));
    }

    public function flush()
    {
        $this->em->flush();
    }

    /** @return User[] */
    private function hydrateItems($results)
    {
        if (empty($results))
        {
            return [];
        }

        $users = [];
        foreach ($results as $result)
        {
            $user = $this->hydrateItem($result);
            array_push($users, $user);
        }

        return $users;
    }

    private function hydrateItem(DoctrineUser $result = null)
    {
        if (empty($result))
        {
            return null;
        }

        $creation_date = \DateTimeImmutable::createFromMutable($result->getCreationDate());

        $user = new User(
            new UserId($result->getId()), $result->getName(), new Email($result->getEmail()), $creation_date
        );

        return $user;
    }
}
