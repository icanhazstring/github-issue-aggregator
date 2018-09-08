<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Issue;
use App\Entity\Repository;
use App\Filter\RequirementFilter;
use App\Provider\GithubProvider;
use Zend\Hydrator\HydratorInterface;

/**
 * Class GithubService
 *
 * @package App\Service
 * @author  icanhazstring <blubb0r05+github@gmail.com>
 */
class GithubService
{
    public const BASE_ISSUES_URI = 'https://github.com/issues?q=';

    private $provider;
    private $filter;
    private $hydrator;

    public function __construct(
        GithubProvider $provider,
        RequirementFilter $filter,
        HydratorInterface $hydrator
    ) {
        $this->provider = $provider;
        $this->filter = $filter;
        $this->hydrator = $hydrator;
    }

    public function getRootRequirements(string $owner, string $repository): array
    {
        $json = \GuzzleHttp\json_decode($this->provider->loadComposerJson($owner, $repository), true);
        $requirements = array_merge(
            [$json['name'] => '*'],
            $json['require'],
            $json['require-dev'] ?? []
        );

        return array_filter($requirements, $this->filter, ARRAY_FILTER_USE_KEY);
    }

    /**
     * @param Repository[] $repositories
     * @return string
     */
    public function buildIssueFilterUri(array $repositories): string
    {
        $uriParts = array_reduce($repositories, function ($carry, Repository $repo) {
            $carry[] = 'repo:' . $repo->getName();

            return $carry;
        }, []);

        $uriParts[] = 'is:open';
        $uriParts[] = 'type:issue';

        return self::BASE_ISSUES_URI . urlencode(implode(' ', $uriParts));
    }

    /**
     * @param Repository[] $repositories
     * @return array
     */
    public function loadIssuesForRepositories(array $repositories): array
    {
        foreach ($repositories as $repository) {
            $this->loadIssueForRepository($repository);
        }

        return $repositories;
    }

    /**
     * @param Repository $repository
     */
    public function loadIssueForRepository(Repository $repository): void
    {
        $result = $this->provider->loadIssues($repository->getOwner(), $repository->getRepository());
        $issues = [];

        foreach ($result['items'] as $issueData) {
            $issues[] = $this->hydrator->hydrate($issueData, new Issue());
        }

        $repository->setIssues($issues);
    }
}
