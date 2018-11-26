<?php
declare(strict_types=1);

namespace Stratadox\Json;

/**
 * Parser for json strings; Factory for Json objects.
 *
 * @author Stratadox
 */
final class JsonParser implements Parser
{
    private const IMMUTABLE = false;
    private const MUTABLE = true;

    /** @var Parser[] Cache for the parsers */
    private static $thatIs = [];

    /** @var bool Whether the resulting Json object should be mutable */
    private $makesMutableJson;

    private function __construct(bool $mutable)
    {
        $this->makesMutableJson = $mutable;
    }

    /**
     * Produces a json parser to serve as factory for Json objects.
     *
     * By default, the parser will produce immutable json objects.
     * This method will not always produce a new parser per se, since there are
     * only two possible states (mutable of immutable) for the factory, it makes
     * little sense to create more instances than those two.
     *
     * @see Json The factory produces Json objects from input strings.
     * @see JsonParser::mutable()
     *
     * @return Parser A json parser which creates ImmutableJson objects.
     */
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
