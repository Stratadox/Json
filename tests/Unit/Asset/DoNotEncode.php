<?php
declare(strict_types=1);

namespace Stratadox\Json\Test\Unit\Asset;

use BadMethodCallException;
use JsonSerializable;

final class DoNotEncode implements JsonSerializable
{
    private $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function jsonSerialize()
    {
        throw new BadMethodCallException($this->message);
    }
}
