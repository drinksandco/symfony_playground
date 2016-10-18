<?php

namespace UserManager\ReadModel\Application\Service\User\GetById;

use UserManager\Domain\Model\User\Skill;
use UserManager\Domain\Model\User\User;

class UserToArrayMarshaller implements GetByIdMarshaller
{
    public function __invoke(User $a_user)
    {
        $skills = $a_user->skills()->items();

        $skills_array = [];

        if (!empty($skills))
        {
            /** @var Skill $skill */
            foreach ($skills as $skill)
            {
                $skills_array[]['name'] = $skill->name();
            }
        }

        return [
            'id'       => $a_user->userId()->userId(),
            'name'     => $a_user->name(),
            'surname'  => $a_user->surname(),
            'username' => $a_user->username(),
            'email'    => $a_user->email()->email(),
            'skills'   => $skills_array
        ];
    }
}
