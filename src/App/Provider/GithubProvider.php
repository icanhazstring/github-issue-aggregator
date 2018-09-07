<?php
declare(strict_types=1);

namespace App\Provider;

use App\Cache\ProviderCacheInterface;
use Github\Client;

class GithubProvider
{
    private $client;
    private $cache;

    public function __construct(Client $client, ProviderCacheInterface $cache)
    {
        $this->client = $client;
        $client->authenticate('6ad7ebbaa1326143bad897779f592d0f63e5c9fd', null, Client::AUTH_HTTP_TOKEN);

        $this->cache = $cache;
    }

    public function loadComposerJson(string $owner, string $repository): string
    {
        if ($this->cache->has(self::class, $owner . $repository)) {
            return $this->cache->get(self::class, $owner . $repository);
        }

        $response = $this->client->repository()->contents()->show($owner, $repository, 'composer.json');
        $content = base64_decode($response['content']);
        $this->cache->set(self::class, $owner . $repository, $content);

        return $content;
    }
}
