<?php
declare(strict_types=1);

namespace Stratadox\Json;

use function json_encode;
use const JSON_ERROR_NONE;
use function json_last_error;
use function json_last_error_msg;
use Throwable;

trait JsonEncoding
{
    /** @throws InvalidJson */
    private function encode($decodedJsonData): string
    {
        try {
            $encoded = json_encode($decodedJsonData);
        } catch (Throwable $exception) {
            throw InputDataCannotBeEncoded::encountered($exception);
        }
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw InputDataCannotBeEncoded::found(json_last_error_msg());
        }
        return $encoded;
    }
}

