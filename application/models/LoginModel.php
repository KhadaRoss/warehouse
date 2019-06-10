<?php

namespace models;

class LoginModel extends Model
{
    const ALGORITHM = \PASSWORD_BCRYPT;

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
        parent::__construct();

        $this->username = \strtolower($username);
        $this->password = $password;
    }

    /**
     * @return void
     */
    public function doLogin(): void
    {
        $userData = $this->getUserData($this->username);

        if ($userData['userId'] === 0 || !password_verify($this->password, $userData['passwordHash'])) {
            return;
        }

        new IdentityModel($userData['userId'], $this->username);
    }

    /**
     * @param string $password
     *
     * @return string
     */
    private function getHashedPassword(string $password): string
    {
        return \password_hash(
            $password,
            self::ALGORITHM
        );
    }

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
    public function manuallyRegisterUser(): void
    {
        $query = <<<SQL
REPLACE INTO users (userId, username, passwordHash) VALUES (:userId, :username, :passwordHash);
SQL;

        $this->prepareAndExecute(
            $query,
            [
                'userId'       => '',
                'username'     => '',
                'passwordHash' => $this->getHashedPassword(''),
            ]
        );
    }
}
