<?php

declare(strict_types=1);

namespace PhperKaig;

use DateTime;

final class DateTimeEndpoint
{
    public function __construct(
        public readonly DateTime $value,
        public readonly bool $inclusive,
    ) {}

    public static function icluding(string $dateTimeStr): DateTimeEndpoint
    {
        return new DateTimeEndpoint(
            value: new DateTime($dateTimeStr),
            inclusive: true
        );
    }

    public static function excluding(string $dateTimeStr): DateTimeEndpoint
    {
        return new DateTimeEndpoint(
            value: new DateTime($dateTimeStr),
            inclusive: false
        );
    }
}
