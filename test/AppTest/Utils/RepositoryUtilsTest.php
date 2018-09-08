<?php
declare(strict_types=1);

namespace AppTest\Utils;

use App\Entity\Repository;
use App\Utils\RepositoryUtils;
use PHPUnit\Framework\TestCase;

/**
 * Class RepositoryUtilsTest
 *
 * @package AppTest\Utils
 * @author  icanhazstring <blubb0r05+github@gmail.com>
 */
class RepositoryUtilsTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldSortRepositoresAccordingToLevenshteinDistance(): void
    {
        $packageNames = [
            'phpunit/php-timer'             => 'sebastianbergmann/php-timer',
            'sebastian/diff'                => 'sebastianbergmann/diff',
            'sebastian/exporter'            => 'sebastianbergmann/exporter',
            'sebastian/version'             => 'sebastianbergmann/version',
            'sebastian/comparator'          => 'sebastianbergmann/comparator',
            'sebastian/environment'         => 'sebastianbergmann/environment',
            'sebastian/global-state'        => 'sebastianbergmann/global-state',
            'phpunit/php-file-iterator'     => 'sebastianbergmann/php-file-iterator',
            'phpunit/php-text-template'     => 'sebastianbergmann/php-text-template',
            'phpunit/php-code-coverage'     => 'sebastianbergmann/php-code-coverage',
            'sebastian/object-enumerator'   => 'sebastianbergmann/object-enumerator',
            'sebastian/resource-operations' => 'sebastianbergmann/resource-operations',
            'phar-io/manifest'              => 'phar-io/manifest',
            'phar-io/version'               => 'phar-io/version',
            'phpspec/prophecy'              => 'phpspec/prophecy',
            'myclabs/deep-copy'             => 'myclabs/DeepCopy',
            'doctrine/instantiator'         => 'doctrine/instantiator',
        ];

        $inputNames = array_merge([], $packageNames);
        shuffle($inputNames);

        $repositories = [];

        foreach ($packageNames as $packageName => $repositoryName) {
            $repository = new Repository();
            $repository->setPackageName($packageName);
            $repository->setName($repositoryName);
            $repositories[] = $repository;
        }

        $util = new RepositoryUtils();
        $sort = $util->sortByLevenshteinDistance('sebastianbergmann/phpunit', $repositories);

        $actualPackageNames = [];
        foreach ($sort as $repository) {
            $actualPackageNames[$repository->getPackageName()] = $repository->getName();
        }

        $this->assertNotEquals($inputNames, $actualPackageNames);
        $this->assertEquals($packageNames, $actualPackageNames);

    }
}
