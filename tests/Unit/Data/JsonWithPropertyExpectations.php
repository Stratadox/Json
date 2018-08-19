<?php
declare(strict_types=1);

namespace Stratadox\Json\Test\Unit\Data;

trait JsonWithPropertyExpectations
{
    public function validJsonStringsWithPropertyExpectations(): array
    {
        return [
            'null' => [
                'null',
                [
                    ['path' => [], 'value' => null],
                ],
            ],
            'string' => [
                '"string"',
                [
                    ['path' => [], 'value' => 'string'],
                ],
            ],
            'number' => [
                '123',
                [
                    ['path' => [], 'value' => 123],
                ],
            ],
            'Plain object' => [
                '{"foo":"bar","number":1}',
                [
                    ['path' => ['foo'], 'value' => 'bar'],
                    ['path' => ['number'], 'value' => 1],
                ],
            ],
            'Nested object' => [
                '{"foo":{"bar":"baz"}}',
                [
                    ['path' => ['foo', 'bar'], 'value' => 'baz'],
                ],
            ],
            'Plain list' => [
                '["foo","bar","baz"]',
                [
                    ['path' => ['0'], 'value' => 'foo'],
                    ['path' => ['1'], 'value' => 'bar'],
                    ['path' => ['2'], 'value' => 'baz'],
                ],
            ],
            'Nested list' => [
                '[["foo","bar","baz"],[10,20,30]]',
                [
                    ['path' => ['0', '0'], 'value' => 'foo'],
                    ['path' => ['0', '1'], 'value' => 'bar'],
                    ['path' => ['0', '2'], 'value' => 'baz'],
                    ['path' => ['1', '0'], 'value' => 10],
                    ['path' => ['1', '1'], 'value' => 20],
                    ['path' => ['1', '2'], 'value' => 30],
                ],
            ],
            'List of objects' => [
                '[{"foo":"bar"},{"foo":"baz"}]',
                [
                    ['path' => ['0', 'foo'], 'value' => 'bar'],
                    ['path' => ['1', 'foo'], 'value' => 'baz'],
                ],
            ],
            'Object with lists' => [
                '{"booleans":[true, false, true, true, false],"empty.list":[]}',
                [
                    ['path' => ['booleans', '0'], 'value' => true],
                    ['path' => ['booleans', '4'], 'value' => false],
                    ['path' => ['empty.list'], 'value' => []],
                ],
            ],
        ];
    }
}
