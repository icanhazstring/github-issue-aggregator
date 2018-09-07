<?php
declare(strict_types=1);

namespace AppTest\Provider;

use App\Cache\MemoryProviderCache;
use App\Provider\GithubProvider;
use Github\Api\Repo;
use Github\Api\Repository\Contents;
use Github\Client;
use PHPUnit\Framework\TestCase;

class GithubProviderTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function itShouldReturnJsonContent(): void
    {
        $json = [
            'content' => base64_encode('testdata')
        ];

        $content = $this->prophesize(Contents::class);
        $content->show('test', 'user', 'composer.json')->shouldBeCalled()->willReturn($json);
        $repo = $this->prophesize(Repo::class);
        $repo->contents()->shouldBeCalled()->willReturn($content->reveal());
        $client = $this->prophesize(Client::class);
        $client->repository()->shouldBeCalled()->willReturn($repo->reveal());

        $provider = new GithubProvider($client->reveal(), new MemoryProviderCache());
        $this->assertSame('testdata', $provider->loadComposerJson('test', 'user'));
    }

    /**
     * @test
     * @return void
     */
    public function itShouldNotCallClientMultipleTimesOnSameData(): void
    {
        $json = [
            'content' => base64_encode('testdata')
        ];

        $content = $this->prophesize(Contents::class);
        $content->show('test', 'user', 'composer.json')->shouldBeCalledOnce()->willReturn($json);
        $repo = $this->prophesize(Repo::class);
        $repo->contents()->shouldBeCalledOnce()->willReturn($content->reveal());
        $client = $this->prophesize(Client::class);
        $client->repository()->shouldBeCalledOnce()->willReturn($repo->reveal());

        $provider = new GithubProvider($client->reveal(), new MemoryProviderCache());

        $provider->loadComposerJson('test', 'user');
        $provider->loadComposerJson('test', 'user');
    }

    /**
     * @test
     * @return void
     */
    public function itShouldNotCallClientMultipleTimesWithOtherProvider(): void
    {
        $json = [
            'content' => base64_encode('testdata')
        ];

        $content = $this->prophesize(Contents::class);
        $content->show('test', 'user', 'composer.json')->shouldBeCalledOnce()->willReturn($json);
        $repo = $this->prophesize(Repo::class);
        $repo->contents()->shouldBeCalledOnce()->willReturn($content->reveal());
        $client = $this->prophesize(Client::class);
        $client->repository()->shouldBeCalledOnce()->willReturn($repo->reveal());

        $cache = new MemoryProviderCache();
        $provider = new GithubProvider($client->reveal(), $cache);
        $provider->loadComposerJson('test', 'user');

        $provider2 = new GithubProvider($client->reveal(), $cache);
        $provider2->loadComposerJson('test', 'user');
    }
}
