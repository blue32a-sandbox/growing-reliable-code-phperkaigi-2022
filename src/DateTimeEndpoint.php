<?php

declare(strict_types=1);

namespace PhperKaigi;

use DateTimeImmutable;

final class DateTimeEndpoint
{
    private readonly DateTimeImmutable $value;

    public function __construct(
        DateTimeImmutable $value,
        public readonly bool $inclusive,
    ) {
        $this->value = DateTimeImmutable::createFromInterface($value);
    }

    public function value(): DateTimeImmutable
    {
        return DateTimeImmutable::createFromInterface($this->value);
    }

    public static function icluding(string $dateTimeStr): DateTimeEndpoint
    {
        return new DateTimeEndpoint(
            value: new DateTimeImmutable($dateTimeStr),
            inclusive: true
        );
    }

    public static function excluding(string $dateTimeStr): DateTimeEndpoint
    {
        return new DateTimeEndpoint(
            value: new DateTimeImmutable($dateTimeStr),
            inclusive: false
        );
    }
}
