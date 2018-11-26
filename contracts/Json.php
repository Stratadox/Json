<?php
declare(strict_types=1);

namespace Stratadox\Json;

/**
 * Object representation of a json string.
 *
 * @author Stratadox
 */
interface Json
{
    /**
     * Checks whether the path leads to a value in the json structure.
     *
     * @param string ...$path The offset at each indentation level.
     * @return bool           Whether the path is valid.
     */
    public function has(string ...$path): bool;

    /**
     * Retrieves the value at the given path.
     *
     * The path consists of a list of strings, where each string is the offset
     * at the respective indentation level.
     *
     * @param string ...$path The offset at each indentation level.
     * @return mixed          The value at the specified location.
     * @throws InvalidOffset  When the path does not lead to a value.
     */
    public function retrieve(string ...$path);

    /**
     * Writes the value to the json structure.
     *
     * Notice that when implemented by an immutable class, this method will
     * return a new copy of the object.
     *
     * @param mixed  $value   The value to write to the json structure.
     * @param string ...$path The location to put the value at. If it does not
     *                        exist, the location will be added to the structure.
     * @return Json           The altered json object: $this for mutable
     *                        implementations or a new copy when immutable.
     * @throws InvalidJson    When the input data cannot be encoded in json
     *                        format.
     */
    public function write($value, string ...$path): Json;

    /**
     * Retrieves the underlying (decoded) json data.
     *
     * @return mixed The raw decoded value.
     */
    public function data();

    /**
     * Retrieves the json-encoded string representation.
     *
     * @return string The json-encoded representation of the data.
     */
    public function __toString(): string;
}
