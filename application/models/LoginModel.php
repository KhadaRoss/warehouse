<?php

namespace models;

use system\identity\Login;

class LoginModel extends Model
{
    /**
     * @param string $username
     *
     * @return array
     */
    public function getUserData(string $username): array
    {
        $query = <<<SQL
SELECT userId, passwordHash FROM users WHERE username = :username
SQL;

        $userData = $this->prepareAndExecute(
            $query,
            ['username' => $username]
        )->fetch();

        return [
            'userId'       => (int)$userData['userId'] ?? 0,
            'passwordHash' => $userData['passwordHash'] ?? ''
        ];
    }

    /**
     * @return void
     */
    public function manuallyRegisterUser()
    {
        $query = <<<SQL
REPLACE INTO users (userId, username, passwordHash) VALUES (:userId, :username, :passwordHash);
SQL;

        $this->prepareAndExecute(
            $query,
            [
                'userId'       => '',
                'username'     => '',
                'passwordHash' => Login::getHashedPassword(''),
            ]
        );
    }
}
