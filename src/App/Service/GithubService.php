<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Repository;
use App\Filter\RequirementFilter;
use App\Provider\GithubProvider;

class GithubService
{
    public const BASE_ISSUES_URI = 'https://github.com/issues?q=';

    private $provider;
    private $filter;

    public function __construct(GithubProvider $provider, RequirementFilter $filter)
    {
        $this->provider = $provider;
        $this->filter = $filter;
    }

    public function getRootRequirements(string $owner, string $repository): array
    {
        $json = \GuzzleHttp\json_decode($this->provider->loadComposerJson($owner, $repository), true);
        $requirements = array_merge($json['require'], $json['require-dev'] ?? []);

        return array_filter($requirements, $this->filter, ARRAY_FILTER_USE_KEY);
    }

    /**
     * @param Repository[] $repositories
     * @return string
     */
    public function buildIssueFilterUri(array $repositories): string
    {
        $uriParts = array_reduce($repositories, function($carry, Repository $repo) {
            $carry[] = 'repo:'.$repo->name;
            return $carry;
        }, []);

        return self::BASE_ISSUES_URI . urlencode(implode(' ', $uriParts));
    }
}
