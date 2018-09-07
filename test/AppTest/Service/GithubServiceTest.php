<?php
declare(strict_types=1);

namespace AppTest\Service;

use App\Entity\Repository;
use App\Filter\RequirementFilter;
use App\Provider\GithubProvider;
use App\Service\GithubService;
use PHPUnit\Framework\TestCase;

class GithubServiceTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function itShouldReturnValidRequirements(): void
    {
        $input = [
            'require' => [
                'owner/repo' => '^2.0',
                'php' => '^7.1'
            ],
            'require-dev' => [
                'test/fubar' => '^2.0'
            ]
        ];

        $expected = [
            'owner/repo' => '^2.0',
            'test/fubar' => '^2.0'
        ];

        $provider = $this->prophesize(GithubProvider::class);
        $provider->loadComposerJson('test', 'repo')->shouldBeCalled()->willReturn(json_encode($input));

        $service = new GithubService($provider->reveal(), new RequirementFilter());
        $this->assertEquals($expected, $service->getRootRequirements('test', 'repo'));
    }

    /**
     * @test
     * @return void
     */
    public function itShouldBuildCorrectIssueSearchQuery(): void
    {
        $provider = $this->prophesize(GithubProvider::class);

        $repositories = [
            new Repository(['name' => 'test/package', 'repository' => 'url1']),
            new Repository(['name' => 'test/package2', 'repository' => 'url2'])
        ];

        $service = new GithubService($provider->reveal(), new RequirementFilter());

        $this->assertEquals(
            GithubService::BASE_ISSUES_URI . urlencode('repo:test/package repo:test/package2 is:open type:issue'),
            $service->buildIssueFilterUri($repositories)
        );
    }
}
