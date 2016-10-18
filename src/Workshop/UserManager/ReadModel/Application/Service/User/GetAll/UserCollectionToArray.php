<?php

namespace UserManager\ReadModel\Application\Service\User\GetAll;

use UserManager\Domain\Model\User\UserCollection;
use UserManager\ReadModel\Application\Service\User\GetById\UserToArrayMarshaller;

class UserCollectionToArray implements GetAllMarshaller
{
    /** @var UserToArrayMarshaller */
    private $user_to_array_marshmaller;

    public function __construct(UserToArrayMarshaller $user_to_array_marshmaller)
    {
        $this->user_to_array_marshmaller = $user_to_array_marshmaller;
    }

    public function __invoke(UserCollection $user_collection)
    {
        if ($user_collection->isEmpty())
        {
            return [];
        }

        $user_array = [];

        foreach ($user_collection->items() as $user)
        {
            $user_array[] = $this->user_to_array_marshmaller->__invoke($user);
        }

        return $user_array;
    }
}
