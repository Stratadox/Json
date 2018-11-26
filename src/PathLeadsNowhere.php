<?php
declare(strict_types=1);

namespace Stratadox\Json;

use function implode;
use OutOfBoundsException as OutOfBounds;
use function sprintf;

/**
 * Exception to notify that the location could not be accessed because it does
 * not exist.
 *
 * @author Stratadox
 */
final class PathLeadsNowhere extends OutOfBounds implements InvalidOffset
{
    public static function didNotFind(
        string $missingKey,
        Json $data,
        string ...$path
    ): self {
        return new self(sprintf(
            'Could not find the value for `%s` in the json data `%s`: ' .
            'the key `%s` does not exist.',
            implode(' -> ', $path),
            $data,
            $missingKey
        ));
    }
}
