<?php

declare(strict_types=1);

namespace Tests\Pnz\JsonException;

use PHPUnit\Framework\TestCase;
use Pnz\JsonException\Json;

class JsonDecodeTest extends TestCase
{
    public function decodeDataProvider()
    {
        yield ['null'];
        yield ['true'];
        yield ['false'];
        yield ['"string"'];
        yield ['[]'];
        yield ['123456789'];
        yield ['["string1", "string2", "string3", null]'];
        yield ['{}'];
        yield ['{"prop1":"string1", "prop2": null}'];
        yield ['{"prop1":"string1", "prop2": null}', true];
    }

    /**
     * @dataProvider decodeDataProvider
     */
    public function testDecode(string $value, bool $assoc = false, int $depth = 512, int $options = 0)
    {
        $original = \json_decode($value, $assoc, $depth, $options);
        $new = Json::decode($value, $assoc, $depth, $options);

        if (\is_object($original)) {
            $this->assertEquals($original, $new);
        } else {
            $this->assertSame($original, $new);
        }
    }

    public function decodeBrokenDataProvider()
    {
        // Syntax errors
        yield ['{string'];
        yield ['string'];
        yield ['NULL'];
        // Maximum stack depth exceeded
        yield ['{"first": {"second": {"third":"value3"}}}', true, 1];
        yield ['{"first": {"second": {"third":"value3"}}}', false, 1];
    }

    /**
     * @dataProvider decodeBrokenDataProvider
     */
    public function testDecodeException(string $value, bool $assoc = false, int $depth = 512)
    {
        $this->expectException(\JsonException::class);
        Json::decode($value, $assoc, $depth);
    }
}
