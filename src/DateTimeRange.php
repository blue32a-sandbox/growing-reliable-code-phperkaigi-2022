<?php

declare(strict_types=1);

namespace PhperKaig;

final class DateTimeRange
{
    public function __construct(
        public readonly DateTimeEndpoint $startAt,
        public readonly DateTimeEndpoint $endAt,
    ) {}
}
