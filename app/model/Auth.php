<?php
use Nette\Security as NS;

class Auth extends Nette\Object implements NS\IAuthenticator
{
    public $database;

    function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    function authenticate(array $credentials)
    {
        list($username, $password) = $credentials;
        $row = $this->database->table('settings')
            ->where('admin_login', $username)->fetch();

        if (!$row) {
            throw new NS\AuthenticationException('User not found.');
        }

        return new NS\Identity($row->id, 'admin');
    }
}