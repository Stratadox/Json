<?php
declare(strict_types=1);

namespace Stratadox\Json;

/**
 * Parser for json input.
 *
 * @author Stratadox
 */
interface Parser
{
    /**
     * Makes the parser produce mutable Json representations.
     *
     * @see MutableJson The returned parser creates mutable json objects.
     *
     * @return Parser A json parser to produce mutable Json representations.
     */
    public function mutable(): Parser;

    /**
     * Makes the parser produce immutable Json representations.
     *
     * @see ImmutableJson The returned parser creates immutable json objects.
     *
     * @return Parser A json parser to produce immutable Json representations.
     */
    public function immutable(): Parser;

    /**
     * Makes a Json representation from a json-encoded string input.
     *
     * @param string $jsonInput The json string to turn into a Json object.
     * @return Json             The Json object that represents the input.
     * @throws InvalidJson      When the input data could not be parsed.
     */
    public function from(string $jsonInput): Json;
}
