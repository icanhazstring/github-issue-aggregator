<?php
declare(strict_types=1);

namespace App\Filter;

class RequirementFilter
{
    public function __invoke(string $requirement): bool
    {
        return preg_match('/\w+\/\w+/i', $requirement) === 1;
    }
}
