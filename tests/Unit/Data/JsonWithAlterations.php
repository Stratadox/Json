<?php
declare(strict_types=1);

namespace Stratadox\Json\Test\Unit\Data;

trait JsonWithAlterations
{
    public function validJsonStringsWithAlterationsAndExpectations(): array
    {
        return [
            'Single string' => [
                '"string"',
                [
                    ['value' => 'changed', 'path' => []]
                ],
                '"changed"',
            ],
            'Single integer' => [
                '123',
                [
                    ['value' => 456, 'path' => []],
                ],
                '456',
            ],
            'Plain object (change)' => [
                '{"foo":"bar","null":null}',
                [
                    ['value' => 'baz', 'path' => ['foo']],
                ],
                '{"foo":"baz","null":null}',
            ],
            'Plain object (append)' => [
                '{"foo":"bar","null":null}',
                [
                    ['value' => 3, 'path' => ['number']],
                ],
                '{"foo":"bar","null":null,"number":3}',
            ],
            'Nested object (change)' => [
                '{"foo":{"bar":"baz"}}',
                [
                    ['value' => 'qux', 'path' => ['foo', 'bar']],
                ],
                '{"foo":{"bar":"qux"}}',
            ],
            'Nested object (append)' => [
                '{"foo":{"bar":"baz"}}',
                [
                    ['value' => 'qux', 'path' => ['foo', 'baz']],
                ],
                '{"foo":{"bar":"baz","baz":"qux"}}',
            ],
            'Plain list (change)' => [
                '["foo","bar","baz"]',
                [
                    ['value' => 'qux', 'path' => ['2']],
                ],
                '["foo","bar","qux"]',
            ],
            'Plain list (append)' => [
                '["foo","bar","baz"]',
                [
                    ['value' => 'qux', 'path' => ['3']],
                ],
                '["foo","bar","baz","qux"]',
            ],
            'Nested list (change)' => [
                '[["foo","bar","baz"],[10,20,30]]',
                [
                    ['value' => 'qux', 'path' => ['0', '2']],
                    ['value' => 11, 'path' => ['1', '1']],
                    ['value' => 12, 'path' => ['1', '2']],
                ],
                '[["foo","bar","qux"],[10,11,12]]',
            ],
            'Nested list (append)' => [
                '[["foo","bar","baz"],[10,20,30]]',
                [
                    ['value' => 'qux', 'path' => ['0', '3']],
                    ['value' => 40, 'path' => ['1', '3']],
                    ['value' => 50, 'path' => ['1', '4']],
                ],
                '[["foo","bar","baz","qux"],[10,20,30,40,50]]',
            ],
            'List of objects (change)' => [
                '[{"foo":"bar"},{"foo":"baz"}]',
                [
                    ['value' => 'baz', 'path' => ['0', 'foo']],
                    ['value' => 'qux', 'path' => ['1', 'foo']],
                ],
                '[{"foo":"baz"},{"foo":"qux"}]',
            ],
            'List of objects (append value)' => [
                '[{"foo":"bar"},{"foo":"baz"}]',
                [
                    ['value' => 'qux', 'path' => ['2', 'foo']],
                ],
                '[{"foo":"bar"},{"foo":"baz"},{"foo":"qux"}]',
            ],
            'List of objects (append map)' => [
                '[{"foo":"bar"},{"foo":"baz"}]',
                [
                    ['value' => ['foo' => 'qux'], 'path' => ['2']],
                ],
                '[{"foo":"bar"},{"foo":"baz"},{"foo":"qux"}]',
            ],
            'Object with lists (change)' => [
                '{"booleans":[true, false, true, true, false],"empty.list":[]}',
                [
                    ['value' => false, 'path' => ['booleans', '2']],
                    ['value' => ['haha', 'not', 'empty'], 'path' => ['empty.list']],
                ],
                '{"booleans":[true,false,false,true,false],"empty.list":["haha","not","empty"]}',
            ],
            'From null to an object' => [
                'null',
                [
                    ['value' => 'qux', 'path' => ['foo', 'bar']]
                ],
                '{"foo":{"bar":"qux"}}',
            ]
        ];
    }
}
