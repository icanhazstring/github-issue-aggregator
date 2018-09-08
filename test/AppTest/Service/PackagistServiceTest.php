<?php
declare(strict_types=1);

namespace AppTest\Service;

use App\Hydrator\RepositoryHydrator;
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

        $hydrator = $this->prophesize(RepositoryHydrator::class);

        $provider = $this->prophesize(PackagistProvider::class);
        $provider->loadPackage('test/package')->shouldBeCalled()->willReturn($package->reveal());
        $service = new PackagistService($provider->reveal(), $hydrator->reveal());

        $this->assertEquals('https://test.url', $service->resolvePackageRepository('test/package'));
    }

    /**
     * @test
     * @return void
     */
    public function itShouldResolveMultiplePackageUrls(): void
    {
        $package1 = $this->prophesize(Package::class);
        $package1->getRepository()->shouldBeCalled()->willReturn('https://github.com/test/realpackage1');

        $package2 = $this->prophesize(Package::class);
        $package2->getRepository()->shouldBeCalled()->willReturn('https://github.com/test/realpackage2');

        $hydrator = new RepositoryHydrator();

        $provider = $this->prophesize(PackagistProvider::class);
        $provider->loadPackage('test/package1')->shouldBeCalled()->willReturn($package1->reveal());
        $provider->loadPackage('test/package2')->shouldBeCalled()->willReturn($package2->reveal());

        $service = new PackagistService($provider->reveal(), $hydrator);

        $repositories = $service->resolveRepositories(['test/package1' => '^2.0', 'test/package2' => '^1.0']);
        $this->assertCount(2, $repositories);

        $this->assertEquals('test/realpackage1', $repositories[0]->getName());
        $this->assertEquals('https://github.com/test/realpackage1', $repositories[0]->getUrl());
        $this->assertEquals('test/realpackage2', $repositories[1]->getName());
        $this->assertEquals('https://github.com/test/realpackage2', $repositories[1]->getUrl());
    }

    /**
     * @test
     * @return void
     */
    public function itShouldResolveRealRepositoryNameByPackageName(): void
    {
        $package = $this->prophesize(Package::class);
        $package->getRepository()->shouldBeCalled()->willReturn('https://github.com/test/package');

        $hydrator = $this->prophesize(RepositoryHydrator::class);

        $provider = $this->prophesize(PackagistProvider::class);
        $provider->loadPackage('test/awesomepackage')->shouldBeCalled()->willReturn($package->reveal());

        $service = new PackagistService($provider->reveal(), $hydrator->reveal());
        $this->assertEquals('test/package', $service->resolvePackageName('test/awesomepackage'));
    }
}
