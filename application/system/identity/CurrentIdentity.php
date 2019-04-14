<?php

namespace system\identity;

use system\router\Router;
use system\router\RouterFactory;

class CurrentIdentity
{
    const IDENTITY_SESSION_KEY = 'identity';
    const IDENTITY_GUEST_ID = 0;

    /** @var array */
    private $identity;

    /**
     * @param array $userData
     */
    public function __construct(array $userData)
    {
        $this->initSession();

        $this->setUserId($userData['userId'] ?? 0);
        $this->setUserName($userData['userName'] ?? 'guest');
    }

    /**
     * @return void
     */
    private function initSession()
    {
        if (empty($_SESSION[self::IDENTITY_SESSION_KEY])) {
            $_SESSION[self::IDENTITY_SESSION_KEY] = [];
        }

        $this->identity = &$_SESSION[self::IDENTITY_SESSION_KEY];
    }

    /**
     * @param int $userId
     *
     * @return CurrentIdentity
     */
    private function setUserId(int $userId): CurrentIdentity
    {
        $this->identity['userId'] = $userId;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->identity['userId'];
    }

    /**
     * @param string $userName
     */
    private function setUserName(string $userName)
    {
        $this->identity['userName'] = $userName;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->identity['userName'];
    }

    /**
     * @return CurrentIdentity
     */
    public static function getIdentity(): CurrentIdentity
    {
        return new self($_SESSION[self::IDENTITY_SESSION_KEY]);
    }

    /**
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return $this->getUserId() !== self::IDENTITY_GUEST_ID;
    }

    /**
     * @return void
     */
    public function logout()
    {
        $this->identity = [];

        Router::redirect(RouterFactory::LOGIN_CONTROLLER);
    }
}
