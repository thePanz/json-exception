<?php

declare(strict_types=1);

namespace Pnz\JsonException;

final class Json
{
    /**
     * This class can not be instantiated, both decode and encode methods must be used as static.
     */
    private function __construct()
    {
    }

    /**
     * Decodes a JSON string.
     *
     * @see https://php.net/manual/en/function.json-decode.php
     *
     * @param string $json    the json string being decoded
     * @param bool   $assoc   when TRUE, returned objects will be converted into associative arrays
     * @param int    $depth   user specified recursion depth
     * @param int    $options bitmask of JSON decode options
     *
     * @throws \JsonException if an error occurs
     *
     * @return mixed the value encoded in json in appropriate PHP type
     */
    public static function decode(string $json, bool $assoc = false, int $depth = 512, int $options = 0)
    {
        $data = \json_decode($json, $assoc, $depth, self::cleanupOptions($options));

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \JsonException(sprintf('Unable to decode JSON: %s', \json_last_error_msg()), \json_last_error());
        }

        return $data;
    }

    /**
     * Returns the JSON representation of a value.
     *
     * @see https://php.net/manual/en/function.json-encode.php
     *
     * @param mixed $value   The value being encoded. Can be any type except a resource.
     *                       All string data must be UTF-8 encoded.
     * @param int   $options Bitmask of options
     * @param int   $depth   Set the maximum depth. Must be greater than zero.
     *
     * @throws \JsonException if an error
     */
    public static function encode($value, int $options = 0, int $depth = 512): string
    {
        $string = \json_encode($value, self::cleanupOptions($options), $depth);

        if (JSON_ERROR_NONE !== \json_last_error()) {
            throw new \JsonException(sprintf('Unable to encode JSON: %s', \json_last_error_msg()), \json_last_error());
        }

        return (string) $string;
    }

    private static function cleanupOptions(int $options): int
    {
        if (\PHP_VERSION_ID >= 70300 && \defined('JSON_THROW_ON_ERROR') && $options >= JSON_THROW_ON_ERROR) {
            // Disable the throw-on-error option as it is handled by this library
            return $options - JSON_THROW_ON_ERROR;
        }

        return $options;
    }
}
