<?php
declare(strict_types=1);

namespace App\Cache;

class MemoryProviderCache implements ProviderCacheInterface
{
    private $cache = [];

    public function has(string $domain, string $key): bool
    {
        return isset($this->cache[$domain][$key]);
    }

    public function set(string $domain, string $key, $value): void
    {
        $this->cache[$domain][$key] = $value;
    }

    public function get(string $domain, string $key)
    {
        return $this->cache[$domain][$key];
    }
}
