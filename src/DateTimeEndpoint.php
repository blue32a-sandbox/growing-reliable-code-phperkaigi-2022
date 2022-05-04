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

    public static function icluding(DateTimeImmutable $value): DateTimeEndpoint
    {
        return new DateTimeEndpoint(
            value: $value,
            inclusive: true
        );
    }

    public static function excluding(DateTimeImmutable $value): DateTimeEndpoint
    {
        return new DateTimeEndpoint(
            value: $value,
            inclusive: false
        );
    }
}
