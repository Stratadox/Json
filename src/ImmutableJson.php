<?php
declare(strict_types=1);

namespace Stratadox\Json;

use function array_pop;

/**
 * Immutable Json Representation.
 *
 * @author Stratadox
 */
final class ImmutableJson implements Json
{
    use JsonEncoding, JsonDecoding, PathValidation;

    /** @var mixed The raw Json data */
    private $data;

    /** @var string The encoded Json string */
    private $encoded;

    /** @throws InvalidJson */
    private function __construct($decodedJsonData)
    {
        $this->data = $decodedJsonData;
        $this->encoded = $this->encode($decodedJsonData);
    }

    /**
     * Produces a Json object from a valid json-encoded string.
     *
     * @param string $jsonInput The json-encoded string input.
     * @return Json             The Json resulting from the input string.
     * @throws InvalidJson      When the input string is not correctly encoded
     *                          in json format.
     */
    public static function fromString(string $jsonInput): Json
    {
        return new ImmutableJson(self::decode($jsonInput));
    }

    /**
     * Produces a Json object from raw input data.
     *
     * @param mixed $input  The "raw" input data. Any input that can be encoded
     *                      as json is accepted.
     * @return Json         The Json resulting from the input data.
     * @throws InvalidJson  When the input data cannot be encoded in json
     *                      format.
     */
    public static function fromData($input): Json
    {
        return new ImmutableJson($input);
    }

    /** @inheritdoc */
    public function has(string ...$path): bool
    {
        $context = $this->data;
        foreach ($path as $offset) {
            if (!$this->isValid($context, $offset)) {
                return false;
            }
            $context = $context[$offset];
        }
        return true;
    }

    /** @inheritdoc */
    public function retrieve(string ...$path)
    {
        $context = $this->data;
        foreach ($path as $offset) {
            $this->mustBeValid($context, $offset, ...$path);
            $context = $context[$offset];
        }
        return $context;
    }

    /** @inheritdoc */
    public function write($value, string ...$path): Json
    {
        if (empty($path)) {
            return new ImmutableJson($value);
        }
        $copy = $this->data;
        $write = &$copy;
        $end = array_pop($path);
        foreach ($path as $offset) {
            $write = &$write[$offset];
        }
        $write[$end] = $value;
        return new ImmutableJson($copy);
    }

    /** @inheritdoc */
    public function data()
    {
        return $this->data;
    }

    /** @inheritdoc */
    public function __toString(): string
    {
        return $this->encoded;
    }
}
