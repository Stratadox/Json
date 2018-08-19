<?php
declare(strict_types=1);

namespace Stratadox\Json\Test\Unit\Data;

trait JsonWithRawData
{
    public function validJsonStringsWithDataExpectations(): array
    {
        return [
            'Plain object' => [
                '{"foo":"bar","number":1}',
                ['foo' => 'bar', 'number' => 1,]
            ],
            'Nested object' => [
                '{"foo":{"bar":"baz"}}',
                ['foo' => ['bar' => 'baz']]
            ],
            'Plain list' => [
                '["foo","bar","baz"]',
                ['foo', 'bar', 'baz']
            ],
            'Nested list' => [
                '[["foo","bar","baz"],[10,20,30]]',
                [['foo', 'bar', 'baz'], [10, 20, 30]]
            ],
            'List of objects' => [
                '[{"foo":"bar"},{"foo":"baz"}]',
                [['foo' => 'bar'], ['foo' => 'baz']]
            ],
            'Object with lists' => [
                '{"booleans":[true, false, true, true, false],"empty.list":[]}',
                [
                    'booleans' => [true, false, true, true, false],
                    'empty.list' => []
                ]
            ],
            'null' => [
                'null',
                null
            ],
            'string' => [
                '"string"',
                'string'
            ],
            'number' => [
                '123',
                123
            ],
        ];
    }
}
