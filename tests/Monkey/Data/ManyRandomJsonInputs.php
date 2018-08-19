<?php
declare(strict_types=1);

namespace Stratadox\Json\Test\Monkey\Data;

use function count;
use Faker\Factory;
use Faker\Generator;
use function json_encode;
use function random_int;
use Stratadox\Json\Json;

trait ManyRandomJsonInputs
{
    private static $SAFEGUARD = 3;

    public function randomJsonObjectsAndStrings(): array
    {
        $generated = Factory::create();
        $data = [];
        while (count($data) < 50) {
            $json = $this->randomJson($generated);
            $data["Json: `$json`"] = [
                $json,
                $this->jsonObjectFrom($generated, $json),
            ];
        }
        return $data;
    }

    private function randomJson(Generator $random): string
    {
        return json_encode($this->generateElement($random));
    }

    private function generateElement(Generator $random, int $safeguard = 0)
    {
        return $random->randomElement([
            null,
            $random->boolean,
            $random->numberBetween(-1000, 1000),
            $random->randomFloat(),
            $this->generateString($random),
            $this->generateArray($random, $safeguard),
        ]);
    }

    private function generateArray(Generator $random, int $safeguard = 0): array
    {
        if (++$safeguard > self::$SAFEGUARD) {
            return [];
        }
        $size = random_int(1, 5);
        $values = [];
        for ($i = 0; $i < $size; ++$i) {
            $key = $random->boolean(90) ? $i : $this->generateString($random);
            $values[$key] = $this->generateElement($random, $safeguard);
        }
        return $values;
    }

    private function generateString(Generator $random): string
    {
        return (string) $random->randomElement([
            $random->name,
            $random->word,
            $random->sentence,
            $random->numberBetween(-1000, 1000),
        ]);
    }

    /** @see RandomJsonObjects::jsonObjectFrom() */
    abstract protected function jsonObjectFrom(Generator $random, string $input): Json;
}
