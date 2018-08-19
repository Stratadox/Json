<?php
declare(strict_types=1);

namespace Stratadox\Json;

interface Parser
{
    /**
     * Makes the parser produce mutable Json representations.
     *
     * @return Parser A json parser to produce mutable Json representations.
     */
    public function mutable(): Parser;

    /**
     * Makes the parser produce immutable Json representations.
     *
     * @return Parser A json parser to produce immutable Json representations.
     */
    public function immutable(): Parser;

    /**
     * Makes a Json representation from a json-encoded string input.
     *
     * @param string $jsonInput
     * @return Json
     * @throws InvalidJson
     */
    public function from(string $jsonInput): Json;
}
