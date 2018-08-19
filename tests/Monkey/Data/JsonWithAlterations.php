<?php
declare(strict_types=1);

namespace Stratadox\Json\Test\Monkey\Data;

use Faker\Factory;
use Faker\Generator;
use Stratadox\Json\Json;

trait JsonWithAlterations
{
    public function jsonWithAlterations(): array
    {
        $random = Factory::create();

        $originalWord = $random->word;
        do {
            $newWord = $random->word;
        } while ($newWord === $originalWord);

        $originalNumber = $random->numberBetween(-100, 100);
        do {
            $newNumber = $random->numberBetween(-100, 100);
        } while ($newNumber === $originalNumber);

        return [
            "Single string: $originalWord -> $newWord" => [
                $this->jsonObjectFrom($random, '"' . $originalWord . '"'),
                [
                    ['value' => $newWord, 'path' => []]
                ],
                '"' . $newWord . '"',
            ],

            "Single integer: $originalNumber -> $newNumber" => [
                $this->jsonObjectFrom($random, (string) $originalNumber),
                [
                    ['value' => $newNumber, 'path' => []],
                ],
                $newNumber,
            ],

            'Plain object:' .
            ' {"foo":"' . $originalWord . '","null":null} ->' .
            ' {"foo":"' . $newWord . '","null":null}' => [
                $this->jsonObjectFrom(
                    $random,
                    '{"foo":"' . $originalWord . '","null":null}'
                ),
                [
                    ['value' => $newWord, 'path' => ['foo']],
                ],
                '{"foo":"' . $newWord . '","null":null}',
            ],

            'Plain object:' .
            ' {"foo":"bar","null":null} ->' .
            ' {"foo":"bar","null":null,"number":'.$newNumber.'}' => [
                $this->jsonObjectFrom($random, '{"foo":"bar","null":null}'),
                [
                    ['value' => $newNumber, 'path' => ['number']],
                ],
                '{"foo":"bar","null":null,"number":'.$newNumber.'}',
            ],

            'Nested object:' .
            ' {"foo":{"bar":"' . $originalWord . '"}} ->' .
            ' {"foo":{"bar":"' . $newWord . '"}}' => [
                $this->jsonObjectFrom(
                    $random,
                    '{"foo":{"bar":"' . $originalWord . '"}}'
                ),
                [
                    ['value' => $newWord, 'path' => ['foo', 'bar']],
                ],
                '{"foo":{"bar":"' . $newWord . '"}}',
            ],

            'Nested object:' .
            ' append {"foo":{"bar":"baz"}} ->' .
            ' {"foo":{"bar":"baz","baz":"' . $newWord . '"}}' => [
                $this->jsonObjectFrom(
                    $random,
                    '{"foo":{"bar":"baz"}}'
                ),
                [
                    ['value' => $newWord, 'path' => ['foo', 'baz']],
                ],
                '{"foo":{"bar":"baz","baz":"' . $newWord . '"}}',
            ],

            'Plain list:' .
            ' ["foo","bar","' . $originalWord . '"] ->' .
            ' ["foo","bar","' . $newWord . '"]' => [
                $this->jsonObjectFrom(
                    $random,
                    '["foo","bar","' . $originalWord . '"]'
                ),
                [
                    ['value' => $newWord, 'path' => ['2']],
                ],
                '["foo","bar","' . $newWord . '"]',
            ],

            'Plain list:' .
            ' ["foo","bar","baz"] ->' .
            ' ["foo","bar","baz","' . $newWord . '"]' => [
                $this->jsonObjectFrom(
                    $random,
                    '["foo","bar","baz"]'
                ),
                [
                    ['value' => $newWord, 'path' => ['3']],
                ],
                '["foo","bar","baz","' . $newWord . '"]',
            ],

            'Nested list:' .
            ' [["foo","bar","' . $originalWord . '"],[10,20,30]] ->' .
            ' [["foo","bar","' . $newWord . '"],[10,11,12]]' => [
                $this->jsonObjectFrom(
                    $random,
                    '[["foo","bar","' . $originalWord . '"],[10,20,30]]'
                ),
                [
                    ['value' => $newWord, 'path' => ['0', '2']],
                    ['value' => 11, 'path' => ['1', '1']],
                    ['value' => 12, 'path' => ['1', '2']],
                ],
                '[["foo","bar","' . $newWord . '"],[10,11,12]]',
            ],

            'Nested list:' .
            ' append [["foo","bar","baz"],[10,20,30]] ->' .
            ' [["foo","bar","baz","' . $newWord . '"],[10,20,30,40,50]]' => [
                $this->jsonObjectFrom(
                    $random,
                    '[["foo","bar","baz"],[10,20,30]]'
                ),
                [
                    ['value' => $newWord, 'path' => ['0', '3']],
                    ['value' => 40, 'path' => ['1', '3']],
                    ['value' => 50, 'path' => ['1', '4']],
                ],
                '[["foo","bar","baz","' . $newWord . '"],[10,20,30,40,50]]',
            ],

            'List of objects:' .
            ' [{"foo":"bar"},{"foo":"' . $originalWord . '"}] ->' .
            ' [{"foo":' . $newNumber . '},{"foo":"' . $newWord . '"}]' => [
                $this->jsonObjectFrom(
                    $random,
                    '[{"foo":"bar"},{"foo":"' . $originalWord . '"}]'
                ),
                [
                    ['value' => $newNumber, 'path' => ['0', 'foo']],
                    ['value' => $newWord, 'path' => ['1', 'foo']],
                ],
                '[{"foo":' . $newNumber . '},{"foo":"' . $newWord . '"}]',
            ],

            'List of objects:' .
            ' [{"foo":"bar"},{"foo":"baz"}] ->' .
            ' [{"foo":"bar"},{"foo":"baz"},{"foo":"' . $newWord . '"}]' => [
                $this->jsonObjectFrom($random, '[{"foo":"bar"},{"foo":"baz"}]'),
                [
                    ['value' => $newWord, 'path' => ['2', 'foo']],
                ],
                '[{"foo":"bar"},{"foo":"baz"},{"foo":"' . $newWord . '"}]',
            ],

            'List of objects:' .
            ' [{"foo":"bar"},{"foo":"baz"}] ->' .
            ' [{"foo":"bar"},{"foo":"baz"},{"foo":"' . $newWord . '"}]' => [
                $this->jsonObjectFrom($random, '[{"foo":"bar"},{"foo":"baz"}]'),
                [
                    ['value' => ['foo' => $newWord], 'path' => ['2']],
                ],
                '[{"foo":"bar"},{"foo":"baz"},{"foo":"' . $newWord . '"}]',
            ],

            'Object with lists:' .
            ' {"numbers":[1, 2, ' . $originalNumber . '],"list":[]} ->' .
            ' {"numbers":[1,2,' . $newNumber . '],"list":["not","empty"]}' => [
                $this->jsonObjectFrom(
                    $random,
                    '{"numbers":[1, 2, ' . $originalNumber . '],"list":[]}'
                ),
                [
                    ['value' => $newNumber, 'path' => ['numbers', '2']],
                    [
                        'value' => ['not', 'empty'],
                        'path' => ['list']
                    ],
                ],
                '{"numbers":[1,2,' . $newNumber . '],"list":["not","empty"]}',
            ],

            'From null to an object:' .
            ' null -> {"foo":{"bar":"' . $newWord . '"}}' => [
                $this->jsonObjectFrom($random, 'null'),
                [
                    ['value' => $newWord, 'path' => ['foo', 'bar']]
                ],
                '{"foo":{"bar":"' . $newWord . '"}}',
            ]
        ];
    }

    /** @see RandomJsonObjects::jsonObjectFrom() */
    abstract protected function jsonObjectFrom(Generator $random, string $input): Json;
}
