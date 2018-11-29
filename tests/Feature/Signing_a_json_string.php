<?php
declare(strict_types=1);

namespace Stratadox\Json\Test\Feature;

use PHPUnit\Framework\TestCase;
use Stratadox\Json\JsonParser;
use Stratadox\Json\Test\Feature\Asset\Signer;

/**
 * @coversNothing
 */
class Signing_a_json_string extends TestCase
{
    /**
     * @test
     * @dataProvider jsonStringsWithSignersAndExpectations
     */
    function adding_a_signature(
        string $jsonInput,
        Signer $signer,
        string $expectedOutput
    ) {
        $this->assertJsonStringEqualsJsonString(
            $expectedOutput,
            $signer->addSignatureTo($jsonInput)
        );
    }

    public function jsonStringsWithSignersAndExpectations(): array
    {
        return [
            'Alice signs {"Book":"Alice in Wonderland"}' => [
                '{"Book":"Alice in Wonderland"}',
                new Signer(JsonParser::create(), 'Alice'),
                '{"Book":"Alice in Wonderland","Signed":{"by":"Alice"}}'
            ],
            'Bob signs ["can","we","fix","it"]' => [
                '["can","we","fix","it"]',
                new Signer(JsonParser::create(), 'Bob'),
                '{"0":"can","1":"we","2":"fix","3":"it","Signed":{"by":"Bob"}}'
            ],
            'Chuck Norris signs the void with mutable json' => [
                'null',
                new Signer(JsonParser::create()->mutable(), 'Chuck Norris'),
                '{"Signed":{"by":"Chuck Norris"}}'
            ],
        ];
    }
}
