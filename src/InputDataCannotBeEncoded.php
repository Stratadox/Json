<?php
declare(strict_types=1);

namespace Stratadox\Json;

use InvalidArgumentException as InvalidArgument;
use function sprintf;
use Throwable;

/**
 * Exception to notify that the input data cannot be encoded in json format.
 *
 * @author Stratadox
 */
final class InputDataCannotBeEncoded extends InvalidArgument implements InvalidJson
{
    /**
     * Produces an `Invalid Json` type exception, to throw when encoding the
     * input caused an exception.
     *
     * @param Throwable $exception The exception that was thrown while encoding.
     * @return InvalidJson         The Json context-specific exception to throw.
     */
    public static function encountered(Throwable $exception): InvalidJson
    {
        return new self(sprintf(
            'Encoding the input caused an exception: %s',
            $exception->getMessage()
        ));
    }

    /**
     * Produces an `Invalid Json` type exception, to throw when encoding the
     * input caused an error.
     *
     * @param string $error The Json error that was found.
     * @return InvalidJson  The Json context-specific exception to throw.
     */
    public static function found(string $error): InvalidJson
    {
        return new self(sprintf(
            'Encoding the input caused an error: %s.',
            $error
        ));
    }
}
