<?php
declare(strict_types=1);

namespace Stratadox\Json;

use function array_pop;

/**
 * Mutable Json Representation.
 *
 * @author Stratadox
 */
final class MutableJson implements Json
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
     * @return Json             The Json object resulting from the input string.
     * @throws InvalidJson      When the input string is not correctly encoded
     *                          in json format.
     */
    public static function fromString(string $jsonInput): Json
    {
        return new MutableJson(self::decode($jsonInput));
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
        return new MutableJson($input);
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
            $this->data = $value;
            $this->encoded = $this->encode($this->data);
            return $this;
        }
        $data = &$this->data;
        $end = array_pop($path);
        foreach ($path as $offset) {
            $data = &$data[$offset];
        }
        $data[$end] = $value;
        $this->encoded = $this->encode($this->data);
        return $this;
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
