<?php
declare(strict_types=1);

namespace App\Provider;

use App\Cache\ProviderCacheInterface;
use Packagist\Api\Client;
use Packagist\Api\Result\Package;

class PackagistProvider
{
    private $client;
    private $cache;

    public function __construct(Client $client, ProviderCacheInterface $cache)
    {
        $this->client = $client;
        $this->cache = $cache;
    }

    public function loadPackage(string $packageName): Package
    {
        if ($this->cache->has(self::class, $packageName)) {
            return $this->cache->get(self::class, $packageName);
        }

        $package = $this->client->get($packageName);
        $this->cache->set(self::class, $packageName, $package);

        return $package;
    }
}
