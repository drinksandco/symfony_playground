<?php

namespace UserManager\Application\Service\User\Add;

use UserManager\Application\Service\Core\ApplicationService;
use UserManager\Domain\Infrastructure\Repository\User\UserRepository;
use UserManager\Domain\Model\Email\Email;
use UserManager\Domain\Model\User\User;
use UserManager\Domain\Model\User\Username;

final class AddUserUseCase implements ApplicationService
{
    /** @var UserRepository */
    private $user_repository;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repository = $a_user_repository;
    }

    public function __invoke(AddUserRequest $a_request)
    {
        $new_user = User::register(
            $a_request->name(),
            $a_request->surname(),
            new Username($a_request->username()),
            new Email($a_request->email())
        );

        $new_user_id = $this->user_repository->add($new_user);

        return $new_user_id;
    }
}
