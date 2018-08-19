<?php
declare(strict_types=1);

namespace Stratadox\Json\Test\Unit\Data;

trait ValidJsonStrings
{
    public function validJsonInputStrings(): array
    {
        return [
            'null' => ['null'],
            'string' => ['"string"'],
            'number' => ['123'],
            'Plain object' => ['{"foo":"bar","number":1}'],
            'Nested object' => ['{"foo":{"bar":"baz"}}'],
            'Plain list' => ['["foo", "bar", "baz"]'],
            'Nested list' => ['[["foo","bar","baz"], [10,20,30]]'],
            'List of objects' => ['[{"foo": "bar"},    {"foo": "baz"}]'],
            'Object with lists' => ['{"booleans":[true,false],"list":[1,2,3]}'],
        ];
    }
}
