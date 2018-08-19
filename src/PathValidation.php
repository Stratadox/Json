<?php
declare(strict_types=1);

namespace Stratadox\Json;

use function array_key_exists;
use function assert;
use function is_array;

trait PathValidation
{
    /** @throws InvalidOffset */
    private function mustBeValid(
        $context,
        string $offset,
        string ...$path
    ): void {
        if ($this->isValid($context, $offset)) {
            return;
        }
        $inTheJson = $this;
        assert($inTheJson instanceof Json);
        throw PathLeadsNowhere::didNotFind($offset, $inTheJson, ...$path);
    }

    private function isValid($context, string $offset): bool
    {
        return is_array($context) && array_key_exists($offset, $context);
    }
}
