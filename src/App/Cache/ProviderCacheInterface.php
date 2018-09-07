<?php
declare(strict_types=1);

namespace App\Cache;

interface ProviderCacheInterface
{
    public function has(string $domain, string $key): bool;
    public function set(string $domain, string $key, $value): void;
    public function get(string $domain, string $key);
}
