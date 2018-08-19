<?php
declare(strict_types=1);

namespace Stratadox\Json\Test\Monkey\Data;

use function assert;
use Faker\Generator;
use Stratadox\Json\ImmutableJson;
use Stratadox\Json\Json;
use Stratadox\Json\MutableJson;

trait RandomJsonObjects
{
    protected function jsonObjectFrom(Generator $random, string $input): Json
    {
        $json = $random->randomElement([
            ImmutableJson::fromString($input),
            MutableJson::fromString($input),
        ]);
        assert($json instanceof Json);
        return $json;
    }
}
