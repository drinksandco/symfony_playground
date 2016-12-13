<?php
namespace Playground\App\Domain\Kernel;

interface CommandBus
{
    public function handle($message);
}
