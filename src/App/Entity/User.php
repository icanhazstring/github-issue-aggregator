<?php
declare(strict_types=1);

namespace App\Entity;

/**
 * Class User
 *
 * @package App\Entity
 * @author  icanhazstring <blubb0r05+github@gmail.com>
 * @codeCoverageIgnore
 */
class User implements NullableInterface
{
    /** @var string */
    private $login;
    /** @var string */
    private $avatarUrl;
    /** @var string */
    private $htmlUrl;

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getAvatarUrl(): string
    {
        return $this->avatarUrl;
    }

    /**
     * @param string $avatarUrl
     */
    public function setAvatarUrl(string $avatarUrl): void
    {
        $this->avatarUrl = $avatarUrl;
    }

    /**
     * @return string
     */
    public function getHtmlUrl(): string
    {
        return $this->htmlUrl;
    }

    /**
     * @param string $htmlUrl
     */
    public function setHtmlUrl(string $htmlUrl): void
    {
        $this->htmlUrl = $htmlUrl;
    }

    /**
     * @inheritDoc
     */
    public function isNull(): bool
    {
        return false;
    }
}
