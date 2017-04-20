<?php

namespace Playground\App\Domain\Model;

use Ramsey\Uuid\Uuid;

abstract class AggregateId
{
    private $id;

    public function __construct(string $an_aggregate_id)
    {
        $this->id = $an_aggregate_id;
    }

    public static function generateUniqueId()
    {
        return new static(Uuid::uuid4());
    }

    public function id()
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->id;
    }

}
