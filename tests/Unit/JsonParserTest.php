<?php
declare(strict_types=1);

namespace Stratadox\Json\Test\Unit;

use PHPUnit\Framework\TestCase;
use ReflectionProperty;
use Stratadox\Json\ImmutableJson;
use Stratadox\Json\JsonParser;
use Stratadox\Json\MutableJson;
use Stratadox\Json\Test\Unit\Data\ValidJsonStrings;

/**
 * @covers \Stratadox\Json\JsonParser
 */
class JsonParserTest extends TestCase
{
    use ValidJsonStrings;

    /**
     * @test
     * @dataProvider validJsonInputStrings
     */
    function parsing_a_json_string_into_an_immutable_representation(
        string $jsonInput
    ) {
        $this->assertEquals(
            ImmutableJson::fromString($jsonInput),
            JsonParser::create()->from($jsonInput)
        );
    }

    /**
     * @test
     * @dataProvider validJsonInputStrings
     */
    function parsing_a_json_string_into_a_mutable_representation(
        string $jsonInput
    ) {
        $this->assertEquals(
            MutableJson::fromString($jsonInput),
            JsonParser::create()->mutable()->from($jsonInput)
        );
    }

    /**
     * @test
     * @dataProvider validJsonInputStrings
     */
    function changing_to_mutable_and_back(
        string $jsonInput
    ) {
        $this->assertEquals(
            ImmutableJson::fromString($jsonInput),
            JsonParser::create()->mutable()->immutable()->from($jsonInput)
        );
    }

    /** @before */
    public function resetCacheForCoverage(): void
    {
        $reflector = new ReflectionProperty(JsonParser::class, 'thatIs');
        $reflector->setAccessible(true);
        $reflector->setValue([]);
    }
}
