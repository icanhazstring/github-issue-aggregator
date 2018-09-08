<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Repository;
use App\Provider\PackagistProvider;
use Zend\Hydrator\HydratorInterface;

/**
 * Class PackagistService
 *
 * @package App\Service
 * @author  icanhazstring <blubb0r05+github@gmail.com>
 */
class PackagistService
{
    private $provider;
    private $hydrator;

    public function __construct(PackagistProvider $provider, HydratorInterface $hydrator)
    {
        $this->provider = $provider;
        $this->hydrator = $hydrator;
    }

    /**
     * @param array $requirements
     * @return Repository[]
     */
    public function resolveRepositories(array $requirements): array
    {
        $repositories = [];

        foreach ($requirements as $packageName => $version) {
            $data = [
                'package_name' => $packageName,
                'name'         => $this->resolvePackageName($packageName),
                'url'          => $this->resolvePackageRepository($packageName)
            ];

            $repositories[] = $this->hydrator->hydrate($data, new Repository());
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
