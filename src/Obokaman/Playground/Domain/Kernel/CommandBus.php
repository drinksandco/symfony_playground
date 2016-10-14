<?php
namespace Obokaman\Playground\Domain\Kernel;

interface CommandBus
{
    public function handle($message);
}
