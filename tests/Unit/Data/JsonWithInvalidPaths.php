<?php
declare(strict_types=1);

namespace Stratadox\Json\Test\Unit\Data;

trait JsonWithInvalidPaths
{
    public function validJsonStringsWithInvalidPaths(): array
    {
        return [
            'Looking for `foo` in {"bar":"baz"}' => [
                '{"bar":"baz"}',
                ['foo'],
                'foo'
            ],
            'Looking for `haystack -> needle` in {"haystack":null}' => [
                '{"haystack":null}',
                ['haystack', 'needle'],
                'needle'
            ],
        ];
    }
}
