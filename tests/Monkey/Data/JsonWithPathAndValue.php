<?php
declare(strict_types=1);

namespace Stratadox\Json\Test\Monkey\Data;

use function json_encode;
use Faker\Factory;
use Faker\Generator;
use Stratadox\Json\Json;

trait JsonWithPathAndValue
{
    public function jsonWithPathAndValue(): array
    {
        $random = Factory::create();

        $singleValue = $random->randomElement([
            null,
            $random->boolean,
            $random->numberBetween(-1000, 1000),
            $random->randomFloat(),
            $random->word
        ]);

        $oneDimensionKey = $random->word;
        $oneDimensionExpectation = $random->sentence;
        $oneDimension = json_encode([
            $random->word => $random->sentence,
            $oneDimensionKey => $oneDimensionExpectation,
            $random->word => $random->numberBetween(0, 10),
        ]);

        $twoDimensionsPath = $random->words(2);
        $twoDimensionsExpectation = $random->sentence;
        $twoDimensions = json_encode([
            $random->word => [
                $random->word => $random->sentence
            ],
            $twoDimensionsPath[0] => [
                $twoDimensionsPath[1] => $twoDimensionsExpectation,
                $random->word => $random->numberBetween(0, 10),
            ],
        ]);

        $threeDimensionsPath = $random->words(3);
        $threeDimensionsExpectation = $random->numberBetween(1, 100);
        $threeDimensions = json_encode([
            $random->word => [
                $random->word => $random->sentence
            ],
            $threeDimensionsPath[0] => [
                $threeDimensionsPath[1] => [
                    $threeDimensionsPath[2] => $threeDimensionsExpectation,
                    $random->word => $random->numberBetween(0, 10),
                ],
                $random->word => $random->numberBetween(0, 10),
            ],
        ]);

        return [
            "Single json-encoded value `$singleValue`" => [
                $singleValue,
                [],
                $this->jsonObjectFrom($random, json_encode($singleValue)),
            ],
            "Single dimension json `$oneDimension` @ $oneDimensionKey" => [
                $oneDimensionExpectation,
                [$oneDimensionKey],
                $this->jsonObjectFrom($random, $oneDimension),
            ],
            "Two dimension json `$twoDimensions` @ {$twoDimensionsPath[0]} ->" .
            " {$twoDimensionsPath[1]}" => [
                $twoDimensionsExpectation,
                $twoDimensionsPath,
                $this->jsonObjectFrom($random, $twoDimensions),
            ],
            "Three dimension json `$threeDimensions` @ {$threeDimensionsPath[0]} ->" .
            " {$threeDimensionsPath[1]} -> {$threeDimensionsPath[2]}" => [
                $threeDimensionsExpectation,
                $threeDimensionsPath,
                $this->jsonObjectFrom($random, $threeDimensions),
            ],
        ];
    }

    /** @see RandomJsonObjects::jsonObjectFrom() */
    abstract protected function jsonObjectFrom(Generator $random, string $input): Json;
}
