<?php
declare(strict_types=1);

namespace App\Provider;

use Github\Client;

class GithubProvider
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function loadComposerJson(string $owner, string $repository): string
    {
        $response = $this->client->repository()->contents()->show($owner, $repository, 'composer.json');
        return base64_decode($response['content']);
    }
}
