# Json

Json handling library for easily reading from and writing to json strings.

## Installation

Install with `composer require stratadox/json`

## What is this?

This library provides a simple object-oriented way of dealing with json strings
in php.

The basic idea is to create a `Json` (php) object from either a json string or 
"raw" data, which represents the json data in the php world. 
Through this object, the contents of the json data can be retrieved. The 
interface also provides a mechanism for altering the json structure, either by 
modifying the current instance or by returning a modified copy.

To produce a json-encoded text representation of the contents, simply casting 
the Json instance to string is enough.

## How to use this?

The package provides two approaches to handling json structures: an immutable
and a mutable way.
They both implement the same interface and differ only in the way they implement
the `write` method.

### Immutable Json

Create an immutable json structure by converting a json-encoded string:
```php
<?php
use Stratadox\Json\ImmutableJson;

$json = ImmutableJson::fromString('{"foo":{"bar":"baz"}}');
```

Or from the "raw" data:
```php
<?php
use Stratadox\Json\ImmutableJson;

$json = ImmutableJson::fromData(['foo' => ['bar' => 'baz']]);
```

Retrieve the values:
```php
assert(['bar' => 'baz'] === $json->retrieve('foo'));
```

Retrieve nested values:
```php
assert('baz' === $json->retrieve('foo', 'bar'));
```

Write values to a new copy:
```php
$changed = $json->write('qux', 'foo', 'bar');
```
(Notice that the value to be written comes before the path.)

The changed structure will contain the new value:
```php
assert('{"foo":{"bar":"qux"}}' === (string) $changed);
```

The original structure will not be modified:
```php
assert('{"foo":{"bar":"baz"}}' === (string) $json);
```

The write-calls can be chained:
```php
$changed = $json
    ->write('qux', 'foo', 'bar')
    ->write(123, 'foo', 'baz');

assert('{"foo":{"bar":"qux","baz":123}}' === (string) $changed);
```

### Mutable Json

Create a mutable json structure by converting a json-encoded string:
```php
<?php
use Stratadox\Json\MutableJson;

$json = MutableJson::fromString('{"foo":{"bar":"baz"}}');
```

Or from the "raw" data:
```php
<?php
use Stratadox\Json\MutableJson;

$json = MutableJson::fromData(['foo' => ['bar' => 'baz']]);
```

Retrieve the values:
```php
assert(['bar' => 'baz'] === $json->retrieve('foo'));
```

Retrieve nested values:
```php
assert('baz' === $json->retrieve('foo', 'bar'));
```

Write new values to the structure:
```php
$json->write('qux', 'foo', 'bar');
```
(Notice that the value to be written comes before the path.)

The write-calls can be chained:
```php
$json
    ->write('qux', 'foo', 'bar')
    ->write(123, 'foo', 'baz');

assert('{"foo":{"bar":"qux","baz":123}}' === (string) $json);
```

### Parser

The JsonParser is a simple factory to create either mutable or immutable Json
instances from string.

```php
<?php
use Stratadox\Json\JsonParser;

$json = JsonParser::create()->from('{"foo":{"bar":"baz"}}');
```

It can be used in cases where you need to parse strings, but don't want to call
the constructors directly.
```php
<?php
namespace Acme;

use Stratadox\Json\Json;
use Stratadox\Json\Parser;

class Signer
{
    private $parseJson;
    private $signatureName;

    public function __construct(Parser $jsonParser, string $name)
    {
        $this->parseJson = $jsonParser;
        $this->signatureName = $name;
    }

    public function addSignatureTo(string $input): string
    {
        return (string) $this->sign($this->parseJson->from($input));
    }

    private function sign(Json $input): Json
    {
        return $input->write($this->signatureName, 'Signed', 'by');
    }
}
```

By default, the parser produces immutable json instances. It can be tuned to
produce mutable instances instead, by using the `mutable` method. To turn it 
back to immutable, use the `immutable` method.

Fun fact: the JsonParser currently allows exactly two instances of its class, 
making it an implementation of the little-known Doubleton pattern.
