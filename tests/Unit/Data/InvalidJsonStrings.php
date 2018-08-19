<?php
declare(strict_types=1);

namespace Stratadox\Json\Test\Unit\Data;

trait InvalidJsonStrings
{
    public function invalidJsonStrings(): array
    {
        return [
            'foo' => [
                'foo',
                'Decoding the input `foo` caused an error: Syntax error.'
            ],
            '{foo:bar}' => [
                '{foo:bar}',
                'Decoding the input `{foo:bar}` caused an error: Syntax error.'
            ],
        ];
    }
}
