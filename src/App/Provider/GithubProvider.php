<?php
declare(strict_types=1);

namespace App\Provider;

use Github\Client;

/**
 * Class GithubProvider
 *
 * @package App\Provider
 * @author  icanhazstring <blubb0r05+github@gmail.com>
 */
class GithubProvider
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $owner
     * @param string $repository
     * @return string
     */
    public function loadComposerJson(string $owner, string $repository): string
    {
        $response = $this->client->repository()->contents()->show($owner, $repository, 'composer.json');

        return base64_decode($response['content']);
    }

    /**
     * @param string $owner
     * @param string $repository
     * @return array
     */
    public function loadIssues(string $owner, string $repository): array
    {
        return $this->client->search()->issues(sprintf('repo:%s/%s+is:open+type:issue', $owner, $repository));
    }
}
