<?php
declare(strict_types=1);

namespace App\Entity;

/**
 * Class Issue
 *
 * @package App\Entity
 * @author  icanhazstring <blubb0r05+github@gmail.com>
 * @codeCoverageIgnore
 */
class Issue
{
    /** @var int */
    private $number;
    /** @var string */
    private $htmlUrl;
    /** @var string */
    private $title;
    /** @var User */
    private $user;
    /** @var User */
    private $assignee;

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @param int $number
     */
    public function setNumber(int $number): void
    {
        $this->number = $number;
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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getAssignee(): User
    {
        return $this->assignee;
    }

    /**
     * @param User $assignee
     */
    public function setAssignee(User $assignee): void
    {
        $this->assignee = $assignee;
    }
}
