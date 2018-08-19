<?php
declare(strict_types=1);

namespace Stratadox\Json\Test\Unit\Data;

trait JsonWithReformattedVersions
{
    public function validJsonStringsWithFormattedExpectations(): array
    {
        return [
            '["foo", "bar", "baz"]' => [
                '["foo", "bar", "baz"]',
                '["foo","bar","baz"]',
            ],
            '{   "foo"     :"bar"  ,"n":1}' => [
                '{   "foo"     :"bar"  ,"n":1}',
                '{"foo":"bar","n":1}',
            ],
            '{"bar":1,"foo":2,"baz":3}' => [
                '{"bar":1,"foo":2,"baz":3}',
                '{"bar":1,"foo":2,"baz":3}',
            ],
            'null' => [
                'null',
                'null'
            ],
        ];
    }
}
