<?php
declare(strict_types=1);

namespace App\Provider;

use Packagist\Api\Client;
use Packagist\Api\Result\Package;

class PackagistProvider
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function loadPackage(string $packageName): Package
    {
        return $this->client->get($packageName);
    }
}
