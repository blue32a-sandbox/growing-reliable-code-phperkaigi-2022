<?php

declare(strict_types=1);

namespace PhperKaigi;

use InvalidArgumentException;

final class DateTimeRange
{
    public function __construct(
        public readonly DateTimeEndpoint $startAt,
        public readonly DateTimeEndpoint $endAt,
    ) {
        $startAtValue = $startAt->value();
        $endAtValue = $endAt->value();
        if ($startAtValue > $endAtValue) {
            throw new InvalidArgumentException('startAt > endAt');
        }
        if ($startAtValue == $endAtValue) {
            if (!$startAt->inclusive || $endAt->inclusive) {
                throw new InvalidArgumentException('Both endpoints should be inclusive if startAt == endAt');
            }
        }
    }
}
