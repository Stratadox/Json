<?php
declare(strict_types=1);

namespace Stratadox\Json;

final class JsonParser implements Parser
{
    private const IMMUTABLE = false;
    private const MUTABLE = true;

    private static $thatIs = [];

    private $makesMutableJson;

    private function __construct(bool $mutable)
    {
        $this->makesMutableJson = $mutable;
    }

    public static function create(): Parser
    {
        if (!isset(JsonParser::$thatIs['immutable'])) {
            JsonParser::$thatIs['immutable'] = new JsonParser(self::IMMUTABLE);
        }
        return JsonParser::$thatIs['immutable'];
    }

    /** @inheritdoc */
    public function mutable(): Parser
    {
        return JsonParser::createMutable();
    }

    /** @inheritdoc */
    public function immutable(): Parser
    {
        return JsonParser::create();
    }

    /** @inheritdoc */
    public function from(string $jsonInput): Json
    {
        if ($this->makesMutableJson) {
            return MutableJson::fromString($jsonInput);
        }
        return ImmutableJson::fromString($jsonInput);
    }

    private static function createMutable(): Parser
    {
        if (!isset(JsonParser::$thatIs['mutable'])) {
            JsonParser::$thatIs['mutable'] = new JsonParser(self::MUTABLE);
        }
        return JsonParser::$thatIs['mutable'];
    }
}
