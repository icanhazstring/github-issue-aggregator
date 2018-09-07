<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Repository;
use App\Provider\PackagistProvider;

class PackagistService
{
    private $provider;

    public function __construct(PackagistProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param array $requirements
     * @return Repository[]
     */
    public function resolveRepositories(array $requirements): array
    {
        $repositories = [];

        foreach ($requirements as $packageName => $version) {
            $repositories[] = new Repository([
                'name'       => $this->resolvePackageName($packageName),
                'repository' => $this->resolvePackageRepository($packageName)
            ]);
        }

        return $repositories;
    }

    public function resolvePackageRepository(string $packageName): string
    {
        return $this->provider->loadPackage($packageName)->getRepository();
    }

    public function resolvePackageName(string $packageName): string
    {
        $repository = $this->provider->loadPackage($packageName)->getRepository();

        return str_replace('https://github.com/', '', $repository);
    }
}
