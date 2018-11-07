<?php

declare(strict_types=1);

namespace Tests\Pnz\JsonException;

use PHPUnit\Framework\TestCase;
use Pnz\JsonException\Json;

class JsonEncodeTest extends TestCase
{
    public function encodeDataProvider()
    {
        yield [null];
        yield [false];
        yield [true];
        yield ['string'];
        yield [123456789];
        yield [[]];
        yield [['string1', 'string2', 'string3']];
        yield [new \stdClass()];
    }

    /**
     * @dataProvider encodeDataProvider
     */
    public function testEncode($value, int $options = 0, int $depth = 512)
    {
        $original = \json_encode($value, $options, $depth);
        $new = Json::encode($value, $options, $depth);

        $this->assertSame($original, $new);
    }

    public function encodeBrokenDataProvider()
    {
        yield [['first' => ['second' => 'value']], 0, 1];
    }

    /**
     * @dataProvider encodeBrokenDataProvider
     */
    public function testEncodeException($value, int $options = 0, int $depth = 512)
    {
        $this->expectException(\JsonException::class);
        Json::encode($value, $options, $depth);
    }
}
