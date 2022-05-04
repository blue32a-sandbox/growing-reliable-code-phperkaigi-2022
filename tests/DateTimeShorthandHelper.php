<?php

declare(strict_types=1);

namespace Tests;

use DateTimeImmutable;
use DateTimeZone;

final class DateTimeShorthandHelper
{
    public static function jst(string $dateTimeStr): DateTimeImmutable
    {
        return new DateTimeImmutable($dateTimeStr, new DateTimeZone('Asia/Tokyo'));
    }

    public static function utc(string $dateTimeStr): DateTimeImmutable
    {
        return new DateTimeImmutable($dateTimeStr, new DateTimeZone('UTC'));
    }
}
