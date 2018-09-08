<?php
declare(strict_types=1);

namespace AppTest\Hydrator;

use App\Entity\Repository;
use App\Hydrator\RepositoryHydrator;
use PHPUnit\Framework\TestCase;

/**
 * Class RepositoryHydratorTest
 *
 * @package AppTest\Hydrator
 * @author  icanhazstring <blubb0r05+github@gmail.com>
 */
class RepositoryHydratorTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldCreateRepositoryFromNameAndUrl(): void
    {
        $data = [
            'name' => 'owner/repo',
            'url'  => 'https://github.com/owner/repo'
        ];

        $hydrator = new RepositoryHydrator();

        $repo = $hydrator->hydrate($data, new Repository());

        $this->assertEquals('owner/repo', $repo->getName());
        $this->assertEquals('https://github.com/owner/repo', $repo->getUrl());
        $this->assertEquals('owner', $repo->getOwner());
        $this->assertEquals('repo', $repo->getRepository());
    }

    /**
     * @test
     */
    public function itShouldCreateRepositoryFromFullData(): void
    {
        $data = [
            'packageName' => 'a/b',
            'name'        => 'owner/repo',
            'url'         => 'https://github.com/owner/repo',
            'owner'       => 'customowner',
            'repository'  => 'customrepo'
        ];

        $hydrator = new RepositoryHydrator();

        $repo = $hydrator->hydrate($data, new Repository());

        $this->assertEquals('a/b', $repo->getPackageName());
        $this->assertEquals('owner/repo', $repo->getName());
        $this->assertEquals('https://github.com/owner/repo', $repo->getUrl());
        $this->assertEquals('customowner', $repo->getOwner());
        $this->assertEquals('customrepo', $repo->getRepository());
    }
}
