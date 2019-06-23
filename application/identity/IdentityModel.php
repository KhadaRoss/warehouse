<?php

namespace identity;

use PDO;
use system\Model;

class IdentityModel extends Model
{
    const GUEST_USER_ID = 0;
    const GUEST_USER_NAME = 'guest';
    const IDENTITY_SESSION_KEY = 'identity';

    /** @var IdentityModel */
    private static $identity;
    /** @var int */
    private $userId;
    /** @var string */
    private $userName;

    /**
     * @param PDO    $database
     * @param int    $userId
     * @param string $userName
     */
    public function __construct(PDO $database, int $userId, string $userName)
    {
        parent::__construct($database);

        $this->setUserId($userId);
        $this->setUserName($userName);
        $this->preserveSession();

        self::$identity = $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     *
     * @return IdentityModel
     */
    private function setUserId(int $userId): IdentityModel
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     *
     * @return IdentityModel
     */
    private function setUserName(string $userName): IdentityModel
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * @return void
     */
    private function preserveSession(): void
    {
        $_SESSION[self::IDENTITY_SESSION_KEY] = [
            'userId'   => $this->getUserId(),
            'userName' => $this->getUserName(),
        ];
    }

    /**
     * @param PDO   $database
     * @param array $userData
     */
    private static function createBySession(PDO $database, array $userData): void
    {
        $userId = $userData['userId'] ?? self::GUEST_USER_ID;
        $userName = $userData['userName'] ?? self::GUEST_USER_NAME;

        new self($database, $userId, $userName);
    }

    /**
     * @param PDO $database
     *
     * @return IdentityModel
     */
    public static function get(PDO $database): IdentityModel
    {
        if (self::$identity === null) {
            self::createBySession($database, $_SESSION[self::IDENTITY_SESSION_KEY] ?? []);
        }

        return self::$identity;
    }

    /**
     * @param PDO $database
     *
     * @return bool
     */
    public static function isLoggedIn(PDO $database): bool
    {
        return self::get($database)->getUserId() !== self::GUEST_USER_ID;
    }

    /**
     * @param PDO $database
     *
     * @return void
     */
    public static function reset(PDO $database): void
    {
        new self($database, self::GUEST_USER_ID, self::GUEST_USER_NAME);
    }
}
