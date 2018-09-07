<?php
declare(strict_types=1);

namespace AppTest\Filter;

use App\Filter\RequirementFilter;
use PHPUnit\Framework\TestCase;

class RequirementFilterTest extends TestCase
{
    private $filter;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->filter = new RequirementFilter();
    }

    /**
     * @test
     * @dataProvider itShouldMatchRequirementsDataProvider
     * @param $expected
     * @param $requirement
     * @return void
     */
    public function itShouldMatchRequirements($expected, $requirement): void
    {
        $filter = $this->filter;
        $this->assertSame($expected, $filter($requirement));
    }

    public function itShouldMatchRequirementsDataProvider(): array
    {
        return [
            [true, 'owner/repo'],
            [false, 'php']
        ];
    }
}
