<?php

namespace Playground\App\Infrastructure\MessageBus\SimpleBus;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use SimpleBus\Message\Bus\Middleware\MessageBusMiddleware;

final class DBTransactionalityCommandBusMiddleware implements MessageBusMiddleware
{
    /** @var Connection */
    private $db_connection;

    public function __construct(EntityManager $an_entity_manager)
    {
        $this->db_connection = $an_entity_manager->getConnection();
    }

    public function handle($message, callable $next_middleware)
    {
        $this->db_connection->beginTransaction();
        try
        {
            $next_middleware($message);
            $this->commit();
        }
        catch (\Exception $e)
        {
            $this->rollback();
            throw $e;
        }
    }

    private function commit()
    {
        if (!$this->db_connection->isTransactionActive())
        {
            return;
        }
        $this->db_connection->commit();
    }

    private function rollback()
    {
        if (!$this->db_connection->isTransactionActive())
        {
            return;
        }
        $this->db_connection->rollBack();
    }
}
