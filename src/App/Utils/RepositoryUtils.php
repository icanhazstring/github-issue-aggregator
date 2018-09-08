<?php
declare(strict_types=1);

namespace App\Utils;

use App\Entity\Repository;
use Jfcherng\Utility\LevenshteinDistance;

class RepositoryUtils
{
    /**
     * @param string $rootPackage
     * @param array  $repositories
     * @return Repository[]
     */
    public function sortByLevenshteinDistance(string $rootPackage, array $repositories): array
    {
        $calculator = new LevenshteinDistance();

        usort($repositories, function (Repository $a, Repository $b) use ($calculator, $rootPackage) {
            $aDistance = $calculator->calculate($rootPackage, $a->getName())['distance'];
            $bDistance = $calculator->calculate($rootPackage, $b->getName())['distance'];

            return $aDistance - $bDistance;
        });

        return $repositories;
    }
}
