<?php

declare(strict_types=1);

namespace Tests;

use DateTimeImmutable;

class DestructiveDateTime extends DateTimeImmutable
{
    private static array $instances;

    public function __construct($datetime, $timezone = null)
    {
        parent::__construct($datetime, $timezone);
        self::$instances[] = $this;
    }

    public function __clone(): void
    {
        self::$instances[] = $this;
    }

    public static function bringEverythingBacktoEpoch(): void
    {
        foreach(self::$instances as $dt) {
            $dt->__construct('1970-01-01T00:00:00.000000+00:00');
        }
    }
}
