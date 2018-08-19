<?php
declare(strict_types=1);

namespace Stratadox\Json\Test\Unit\Data;

use stdClass;
use Stratadox\Json\Test\Unit\Asset\DoNotEncode;

trait StructuresWithExpectations
{
    public function validStructuresWithJsonExpectations(): array
    {
        $object = new stdClass;
        $object->foo = 'bar';

        return [
            'Null' => [
                null,
                'null'
            ],
            'String' => [
                'string',
                '"string"'
            ],
            'Number' => [
                123,
                '123'
            ],
            'Plain map' => [
                ['foo' => 'bar'],
                '{"foo":"bar"}'
            ],
            'Nested map' => [
                ['foo' => ['bar' => 'baz']],
                '{"foo":{"bar":"baz"}}'
            ],
            'Object' => [
                $object,
                '{"foo":"bar"}'
            ],
            'List of strings' => [
                ['foo', 'bar', 'baz'],
                '["foo","bar","baz"]'
            ],
            'List of numbers' => [
                [1, 2, 3],
                '[1,2,3]'
            ],
        ];
    }

    public function invalidStructuresWithExceptionMessages(): array
    {
        $recurse = [];
        $recurse['forever'] = &$recurse;

        return [
            'Stop - exception time' => [
                new DoNotEncode('Stop - exception time!'),
                'Encoding the input caused an exception: Stop - exception time!'
            ],
            'Invalid encoding' => [
                "\xB1\x31",
                'Encoding the input caused an error: Malformed UTF-8 characters, possibly incorrectly encoded.'
            ],
            'Eternal recursion' => [
                $recurse,
                'Encoding the input caused an error: Recursion detected.'
            ],
        ];
    }
}
