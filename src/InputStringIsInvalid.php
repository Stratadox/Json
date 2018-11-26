<?php
declare(strict_types=1);

namespace Stratadox\Json;

use InvalidArgumentException as InvalidArgument;

/**
 * Exception to notify that the input data cannot be decoded from json format.
 *
 * @author Stratadox
 */
final class InputStringIsInvalid extends InvalidArgument implements InvalidJson
{
    /**
     * Produces an `Invalid Json` type exception, to throw when decoding the
     * input caused an error.
     *
     * @param string $error       The error message that was detected.
     * @param string $invalidJson The (invalid) json input that was provided.
     * @return InvalidJson        The Json context-specific exception to throw.
     */
    public static function detected(
        string $error,
        string $invalidJson
    ): InvalidJson {
        return new self(sprintf(
            'Decoding the input `%s` caused an error: %s.',
            $invalidJson,
            $error
        ));
    }
}
