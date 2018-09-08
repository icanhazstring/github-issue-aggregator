<?php
declare(strict_types=1);

namespace App\Provider;

use Packagist\Api\Client;
use Packagist\Api\Result\Package;

/**
 * Class PackagistProvider
 *
 * @package App\Provider
 * @author  icanhazstring <blubb0r05+github@gmail.com>
 */
class PackagistProvider
{
    private $client;

    /**
     * PackagistProvider constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $packageName
     * @return Package
     */
    public function loadPackage(string $packageName): Package
    {
        return $this->client->get($packageName);
    }
}
