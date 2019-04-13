<?php

namespace system\identity;

class CurrentIdentity
{
    const IDENTITY_SESSION_KEY = 'identity';

    /** @var array */
    private $identity;

    /**
     * @param array $userData
     */
    public function __construct(array $userData)
    {
        $this->initSession();

        $this->setUserId($userData['userId']);
        $this->setUserName($userData['userName']);
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
}
