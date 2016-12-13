<?php

namespace Playground\App\Infrastructure\MessageBus\SimpleBus;

use Playground\App\Domain\Kernel\CommandBus as CommandBusContract;
use SimpleBus\Message\Bus\MessageBus;

final class CommandBus implements CommandBusContract
{
    /** @var MessageBus */
    private $command_bus;

    public function __construct(MessageBus $a_command_bus)
    {
        $this->command_bus = $a_command_bus;
    }

    public function handle($message)
    {
        $this->command_bus->handle($message);
    }
}
