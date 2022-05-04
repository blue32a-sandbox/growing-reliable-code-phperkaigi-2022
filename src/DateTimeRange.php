<?php

declare(strict_types=1);

namespace PhperKaigi;

final class DateTimeRange
{
    public function __construct(
        public readonly DateTimeEndpoint $startAt,
        public readonly DateTimeEndpoint $endAt,
    ) {}
}
