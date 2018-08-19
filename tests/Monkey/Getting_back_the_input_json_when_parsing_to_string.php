<?php
declare(strict_types=1);

namespace Stratadox\Json\Test\Monkey;

use PHPUnit\Framework\TestCase;
use Stratadox\Json\Json;
use Stratadox\Json\Test\Monkey\Data\ManyRandomJsonInputs;
use Stratadox\Json\Test\Monkey\Data\RandomJsonObjects;

/**
 * @coversNothing
 */
class Getting_back_the_input_json_when_parsing_to_string extends TestCase
{
    use RandomJsonObjects, ManyRandomJsonInputs;

    /**
     * @test
     * @dataProvider randomJsonObjectsAndStrings
     */
    function parsing_the_json_object_to_string(
        string $expectedJson,
        Json $object
    ) {
        $this->assertSame($expectedJson, (string) $object);
    }
}
