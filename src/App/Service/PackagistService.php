<?php
declare(strict_types=1);

namespace App\Service;

use App\Provider\PackagistProvider;

class PackagistService
{
    private $provider;

    public function __construct(PackagistProvider $provider)
    {
        $this->provider = $provider;
    }

    public function resolveRepositories(array $requirements): array
    {
        $repositories = [];

        foreach ($requirements as $packageName => $version) {
            $repositories[] = $this->resolveRepository($packageName);
        }

        return array_merge(...$repositories);
    }

    public function resolveRepository(string $packageName): array
    {
        $repositoryUrl = $this->provider->loadPackage($packageName)->getRepository();

        return [$packageName => $repositoryUrl];
    }
}
