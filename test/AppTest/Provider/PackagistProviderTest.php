<?php
declare(strict_types=1);

namespace AppTest\Provider;

use App\Cache\MemoryProviderCache;
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

        $provider = new PackagistProvider($client->reveal(), new MemoryProviderCache());
        $this->assertSame($package->reveal(), $provider->loadPackage('test/package'));
    }

    /**
     * @test
     * @return void
     */
    public function itShouldNotCallClientMultipleTimesOnConsecutiveCallsWithSamePackage(): void
    {
        $cache = new MemoryProviderCache();
        $package = $this->prophesize(Package::class);

        $client = $this->prophesize(Client::class);
        $client->get('test/package')->shouldBeCalledOnce()->willReturn($package->reveal());

        $provider = new PackagistProvider($client->reveal(), $cache);
        $provider->loadPackage('test/package');
        $provider->loadPackage('test/package');
    }

    /**
     * @test
     * @return void
     */
    public function itShouldNotCalLClientOnOverMultiProviders(): void
    {
        $cache = new MemoryProviderCache();
        $package = $this->prophesize(Package::class);

        $client = $this->prophesize(Client::class);
        $client->get('test/package')->shouldBeCalledOnce()->willReturn($package->reveal());

        $provider = new PackagistProvider($client->reveal(), $cache);
        $provider->loadPackage('test/package');

        $provider2 = new PackagistProvider($client->reveal(), $cache);
        $provider2->loadPackage('test/package');
    }
}
