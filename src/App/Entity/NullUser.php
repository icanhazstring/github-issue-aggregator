<?php
declare(strict_types=1);

namespace App\Entity;

/**
 * Class NullUser
 *
 * @package App\Entity
 * @author  icanhazstring <blubb0r05+github@gmail.com>
 * @codeCoverageIgnore
 */
class NullUser extends User
{
    /**
     * @inheritDoc
     */
    public function getLogin(): string
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function getAvatarUrl(): string
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function getHtmlUrl(): string
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function isNull(): bool
    {
        return true;
    }
}
