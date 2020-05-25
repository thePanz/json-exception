<?php

declare(strict_types=1);

if (PHP_VERSION_ID < 70300 && !class_exists('\JsonException')) {
    include_once __DIR__.'/JsonException.php';
}
