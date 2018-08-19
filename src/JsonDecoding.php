<?php
declare(strict_types=1);

namespace Stratadox\Json;

use function json_last_error_msg;

trait JsonDecoding
{
    /** @throws InvalidJson */
    private static function decode(string $input)
    {
        $decoded = json_decode($input, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw InputStringIsInvalid::detected(json_last_error_msg(), $input);
        }
        return $decoded;
    }
}

