<?php
declare(strict_types=1);

namespace Stratadox\Json\Test\Monkey;

use PHPUnit\Framework\TestCase;
use Stratadox\Json\Json;
use Stratadox\Json\Test\Monkey\Data\JsonWithAlterations;
use Stratadox\Json\Test\Monkey\Data\RandomJsonObjects;

/**
 * @coversNothing
 */
class Writing_values_to_the_json_structure extends TestCase
{
    use RandomJsonObjects, JsonWithAlterations;

    /**
     * @test
     * @dataProvider jsonWithAlterations
     */
    function changing_the_contents_of_the_json_data(
        Json $json,
        array $changes,
        string $expected
    ) {
        foreach ($changes as $change) {
            $json = $json->write($change['value'], ...$change['path']);
        }

        $this->assertSame(
            $expected,
            (string) $json
        );
    }
}
