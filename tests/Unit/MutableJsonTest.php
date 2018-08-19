<?php
declare(strict_types=1);

namespace Stratadox\Json\Test\Unit;

use function implode;
use PHPUnit\Framework\TestCase;
use Stratadox\Json\InvalidJson;
use Stratadox\Json\MutableJson;
use Stratadox\Json\InvalidOffset;
use Stratadox\Json\Test\Unit\Data\InvalidJsonStrings;
use Stratadox\Json\Test\Unit\Data\JsonWithAlterations;
use Stratadox\Json\Test\Unit\Data\JsonWithInvalidPaths;
use Stratadox\Json\Test\Unit\Data\JsonWithPropertyExpectations;
use Stratadox\Json\Test\Unit\Data\JsonWithRawData;
use Stratadox\Json\Test\Unit\Data\JsonWithReformattedVersions;
use Stratadox\Json\Test\Unit\Data\StructuresWithExpectations;

/**
 * @covers \Stratadox\Json\MutableJson
 * @covers \Stratadox\Json\InputDataCannotBeEncoded
 * @covers \Stratadox\Json\InputStringIsInvalid
 * @covers \Stratadox\Json\PathLeadsNowhere
 */
class MutableJsonTest extends TestCase
{
    use JsonWithPropertyExpectations;
    use InvalidJsonStrings;
    use JsonWithInvalidPaths;
    use JsonWithReformattedVersions;
    use JsonWithRawData;
    use JsonWithAlterations;
    use StructuresWithExpectations;

    /**
     * @test
     * @dataProvider validJsonStringsWithPropertyExpectations
     */
    function retrieving_the_values_from_json(
        string $jsonInput,
        array $expectedProperties
    ) {
        $json = MutableJson::fromString($jsonInput);
        foreach ($expectedProperties as $expectedProperty) {
            $this->assertSame(
                $expectedProperty['value'],
                $json->retrieve(...$expectedProperty['path'])
            );
        }
    }

    /**
     * @test
     * @dataProvider invalidJsonStrings
     */
    function throwing_an_exception_when_the_json_input_is_invalid(
        string $invalidJson,
        string $expectedExceptionMessage
    ) {
        $this->expectException(InvalidJson::class);
        $this->expectExceptionMessage($expectedExceptionMessage);

        MutableJson::fromString($invalidJson);
    }

    /**
     * @test
     * @dataProvider validJsonStringsWithInvalidPaths
     */
    function throwing_an_exception_when_the_path_does_not_lead_to_a_value(
        string $jsonInput,
        array $invalidPath,
        string $failedKey
    ) {
        $json = MutableJson::fromString($jsonInput);

        $path = implode(' -> ', $invalidPath);
        $this->expectException(InvalidOffset::class);
        $this->expectExceptionMessage(
            "Could not find the value for `$path` in the json data " .
            "`$jsonInput`: the key `$failedKey` does not exist."
        );

        $json->retrieve(...$invalidPath);
    }

    /**
     * @test
     * @dataProvider validJsonStringsWithPropertyExpectations
     */
    function checking_that_the_values_are_in_the_json_data(
        string $jsonInput,
        array $expectedProperties
    ) {
        $json = MutableJson::fromString($jsonInput);
        foreach ($expectedProperties as $expected) {
            $this->assertTrue(
                $json->has(...$expected['path'])
            );
        }
    }

    /**
     * @test
     * @dataProvider validJsonStringsWithInvalidPaths
     */
    function checking_that_the_values_are_not_in_the_json_data(
        string $jsonInput,
        array $path
    ) {
        $json = MutableJson::fromString($jsonInput);
        $this->assertFalse(
            $json->has(...$path)
        );
    }

    /**
     * @test
     * @dataProvider validJsonStringsWithFormattedExpectations
     */
    function formatting_the_object_as_string(
        string $jsonInput,
        string $expectedOutput
    ) {
        $this->assertSame(
            $expectedOutput,
            (string) MutableJson::fromString($jsonInput)
        );
    }

    /**
     * @test
     * @dataProvider validJsonStringsWithDataExpectations
     */
    function retrieving_the_raw_data(string $jsonInput, $expectedData)
    {
        $this->assertSame(
            $expectedData,
            MutableJson::fromString($jsonInput)->data()
        );
    }

    /**
     * @test
     * @dataProvider validStructuresWithJsonExpectations
     */
    function converting_raw_data_to_json(
        $inputData,
        string $expectedJson
    ) {
        $this->assertSame(
            $expectedJson,
            (string) MutableJson::fromData($inputData)
        );
    }

    /**
     * @test
     * @dataProvider invalidStructuresWithExceptionMessages
     */
    function throwing_an_exception_when_the_value_cannot_be_encoded_as_json(
        $invalidInput,
        string $expectedExceptionMessage
    ) {
        $this->expectException(InvalidJson::class);
        $this->expectExceptionMessage($expectedExceptionMessage);

        MutableJson::fromData($invalidInput);
    }

    /**
     * @test
     * @dataProvider validJsonStringsWithAlterationsAndExpectations
     */
    function altering_the_json_structure(
        string $jsonInput,
        array $changes,
        string $expectedOutput
    ) {
        $json = MutableJson::fromString($jsonInput);
        foreach ($changes as $change) {
            $json = $json->write($change['value'], ...$change['path']);
        }
        $this->assertSame(
            $expectedOutput,
            (string) $json
        );
    }

    /**
     * @test
     * @dataProvider validJsonStringsWithAlterationsAndExpectations
     */
    function altering_the_json_structure_by_changing_the_original(
        string $jsonInput,
        array $changes
    ) {
        $original = MutableJson::fromString($jsonInput);
        $changed = $original->write($changes[0]['value'], ...$changes[0]['path']);

        $this->assertJsonStringNotEqualsJsonString(
            $jsonInput,
            (string) $original
        );
        $this->assertSame($original, $changed);
    }
}
