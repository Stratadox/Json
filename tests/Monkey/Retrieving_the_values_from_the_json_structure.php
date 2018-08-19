<?php
declare(strict_types=1);

namespace Stratadox\Json\Test\Monkey;

use PHPUnit\Framework\TestCase;
use Stratadox\Json\Json;
use Stratadox\Json\Test\Monkey\Data\JsonWithPathAndValue;
use Stratadox\Json\Test\Monkey\Data\RandomJsonObjects;

/**
 * @coversNothing
 */
class Retrieving_the_values_from_the_json_structure extends TestCase
{
    use RandomJsonObjects, JsonWithPathAndValue;

    /**
     * @test
     * @dataProvider jsonWithPathAndValue
     */
    function following_the_path_to_the_value(
        $expectedValue,
        array $path,
        Json $json
    ) {
        $this->assertSame(
            $expectedValue,
            $json->retrieve(...$path)
        );
    }
}
