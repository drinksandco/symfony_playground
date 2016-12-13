<?php
namespace Playground\App\Application\Service\User;

use Playground\App\Domain\Model\User\Email;
use Playground\App\Domain\Model\User\UserId;

class EditUserCommand
{
    /** @var string */
    private $user_id;

    /** @var string */
    private $name;

    /** @var string */
    private $email;

    public function __construct($a_user_id, $a_name, $an_email)
    {
        $this->user_id = $a_user_id;
        $this->name    = $a_name;
        $this->email   = $an_email;
    }

    public function userId()
    {
        return new UserId($this->user_id);
    }

    public function name()
    {
        return $this->name;
    }

    public function email()
    {
        return new Email($this->email);
    }
}
