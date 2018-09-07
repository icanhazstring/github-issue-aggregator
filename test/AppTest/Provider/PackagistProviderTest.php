<?php
declare(strict_types=1);

namespace AppTest\Provider;

use App\Provider\PackagistProvider;
use Packagist\Api\Client;
use Packagist\Api\Result\Package;
use PHPUnit\Framework\TestCase;

class PackagistProviderTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function itShouldLoadPackage(): void
    {
        $package = $this->prophesize(Package::class);

        $client = $this->prophesize(Client::class);
        $client->get('test/package')->shouldBeCalled()->willReturn($package->reveal());

        $provider = new PackagistProvider($client->reveal());
        $this->assertSame($package->reveal(), $provider->loadPackage('test/package'));
    }
}
