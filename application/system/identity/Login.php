<?php

namespace system\identity;

use models\LoginModel;

class Login
{
    /** @var string */
    private $username;
    /** @var string */
    private $password;

    /**
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username, string $password)
    {
        $this->username = \strtolower($username);
        $this->password = $password;
    }

    /**
     * @throws LoginException
     *
     * @return void
     */
    public function doLogin()
    {
        $userData = (new LoginModel())->getUserData($this->username);

        if ($userData['userId'] === 0 || !password_verify($this->password, $userData['passwordHash'])) {
            return;
        }

        new CurrentIdentity([
            'userId' => $userData['userId'],
            'userName' => $this->username,
        ]);
    }

    /**
     * @param string $password
     *
     * @return string
     */
    public static function getHashedPassword(string $password): string
    {
        return \password_hash(
            $password,
            \PASSWORD_BCRYPT
        );
    }
}
