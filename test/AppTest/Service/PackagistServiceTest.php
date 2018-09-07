<?php
declare(strict_types=1);

namespace AppTest\Service;

use App\Provider\PackagistProvider;
use App\Service\PackagistService;
use Packagist\Api\Result\Package;
use PHPUnit\Framework\TestCase;

class PackagistServiceTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function itShouldResolvePackageUrl(): void
    {
        $package = $this->prophesize(Package::class);
        $package->getRepository()->shouldBeCalled()->willReturn('https://test.url');

        $provider = $this->prophesize(PackagistProvider::class);
        $provider->loadPackage('test/package')->shouldBeCalled()->willReturn($package->reveal());
        $service = new PackagistService($provider->reveal());

        $this->assertSame(['test/package' => 'https://test.url'], $service->resolveRepository('test/package'));
    }

    /**
     * @test
     * @return void
     */
    public function itShouldResolveMultiplePackageUrls(): void
    {
        $package1 = $this->prophesize(Package::class);
        $package1->getRepository()->shouldBeCalled()->willReturn('https://package1.url');

        $package2 = $this->prophesize(Package::class);
        $package2->getRepository()->shouldBeCalled()->willReturn('https://package2.url');

        $provider = $this->prophesize(PackagistProvider::class);
        $provider->loadPackage('test/package1')->shouldBeCalled()->willReturn($package1->reveal());
        $provider->loadPackage('test/package2')->shouldBeCalled()->willReturn($package2->reveal());

        $service = new PackagistService($provider->reveal());

        $expected = [
            'test/package1' => 'https://package1.url',
            'test/package2' => 'https://package2.url'
        ];

        $actual = $service->resolveRepositories(['test/package1' => '^2.0', 'test/package2' => '^1.0']);

        $this->assertSame($expected, $actual);
    }
}
